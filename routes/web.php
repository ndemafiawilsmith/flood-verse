<?php

use App\Livewire\Home;

use App\Models\Victim;
use App\Models\SafeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', Home::class)->name('home');


Route::post('/admin/flood/selection', function (Request $request) {
    $data = $request->all();

    $victimQuery = Victim::query();
    $safeZoneQuery = SafeZone::query();

    // Rectangle selection
    if ($data['type'] === 'rectangle') {
        $b = $data['bounds'];
        foreach ([$victimQuery, $safeZoneQuery] as $query) {
            $query->whereBetween('latitude', [$b['south'], $b['north']])
                  ->whereBetween('longitude', [$b['west'], $b['east']]);
        }
    }

    // Circle selection
    if ($data['type'] === 'circle') {
        $lat = $data['center']['lat'];
        $lng = $data['center']['lng'];
        $r = $data['radius'] / 1000; // meters → km

        foreach ([$victimQuery, $safeZoneQuery] as $query) {
            $query->selectRaw(
                '*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$lat, $lng, $lat]
            )->having('distance', '<', $r);
        }
    }

    // Polygon selection (approx. bounding box)
    if ($data['type'] === 'polygon') {
        $lats = array_column($data['path'], 'lat');
        $lngs = array_column($data['path'], 'lng');
        foreach ([$victimQuery, $safeZoneQuery] as $query) {
            $query->whereBetween('latitude', [min($lats), max($lats)])
                  ->whereBetween('longitude', [min($lngs), max($lngs)]);
        }
    }

    $victims = $victimQuery->get();
    $safeZones = $safeZoneQuery->get();

    // ✅ Send SMS alerts using Termii
    $apiKey = env('TERMII_API_KEY'); // store this safely in .env
    $senderId = 'FloodAlert'; // your Termii sender ID
    $termiiUrl = 'https://api.ng.termii.com/api/sms/send';

    foreach ($victims as $victim) {
        if (!$victim->contact) continue;

        // 🧭 Find nearest safe zone (if any)
        $nearest = $safeZones->sortBy(function ($zone) use ($victim) {
            return haversineDistance($victim->latitude, $victim->longitude, $zone->latitude, $zone->longitude);
        })->first();

        $message = "⚠️ Flood Alert: Your area ({$victim->location}) may soon be flooded.";

        if ($nearest) {
            $message .= " Please move to the nearest safe zone: {$nearest->name}, located at {$nearest->address}. Stay safe.";
        } else {
            $message .= " No registered safe zone nearby. Move to higher ground immediately.";
        }

        // Send SMS
        try {
            Http::post($termiiUrl, [
                'api_key' => $apiKey,
                'to' => formatPhone($victim->contact),
                'from' => $senderId,
                'sms' => $message,
                'type' => 'plain',
                'channel' => 'generic',
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS to {$victim->contact}: " . $e->getMessage());
        }
    }

    // ✅ Notify Safe Zones
    foreach ($safeZones as $zone) {
        if (!$zone->address || !isset($zone->contact)) continue; // optional field
        try {
            $msg = "🚨 Alert: Victims near your area may seek refuge at your safe zone ({$zone->name}). Please prepare to assist.";
            Http::post($termiiUrl, [
                'api_key' => $apiKey,
                'to' => formatPhone($zone->contact),
                'from' => $senderId,
                'sms' => $msg,
                'type' => 'plain',
                'channel' => 'generic',
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to notify safe zone {$zone->name}: " . $e->getMessage());
        }
    }

    return response()->json([
        'victims' => $victims,
        'safe_zones' => $safeZones,
        'status' => 'Messages sent successfully.',
    ]);
});

/**
 * Helper: Calculate distance between two coordinates (in km)
 */
function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}

/**
 * Helper: Normalize phone number for Termii (Nigeria default)
 */
function formatPhone($number)
{
    $number = preg_replace('/\D/', '', $number);
    if (str_starts_with($number, '0')) {
        $number = '234' . substr($number, 1);
    } elseif (!str_starts_with($number, '234')) {
        $number = '234' . $number;
    }
    return $number;
}



Route::get('/admin/test-sms', function () {
    $apiKey = env('TERMII_API_KEY');
    $senderId = 'N-Alert'; // or env('TERMII_SENDER_ID', 'FloodAlert')
    $termiiUrl = 'https://api.ng.termii.com/api/sms/send';

    // 🔧 Replace with your real phone number for testing
    $testNumber = '08100502093';

    // Message content
    $message = "✅ Test Alert: This is a system test from FloodAlert. If you received this, Termii API is working correctly.";

    try {
        $response = Http::post($termiiUrl, [
            'api_key' => $apiKey,
            'to' => formatPhone($testNumber),
            'from' => $senderId,
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
        ]);

        if ($response->successful()) {
            Log::info('Test SMS sent successfully to ' . $testNumber, ['response' => $response->json()]);
            return response()->json([
                'status' => '✅ Test SMS sent successfully!',
                'number' => $testNumber,
                'response' => $response->json(),
            ]);
        } else {
            Log::error('❌ Test SMS failed.', ['response' => $response->body()]);
            return response()->json([
                'status' => '❌ Test failed to send.',
                'details' => $response->body(),
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error('🚨 Test SMS exception: ' . $e->getMessage());
        return response()->json([
            'status' => '🚨 Exception occurred.',
            'error' => $e->getMessage(),
        ], 500);
    }
});
