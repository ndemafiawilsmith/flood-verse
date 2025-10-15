<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FloodVerse | Home' }}</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #e0f2fe, #bae6fd, #7dd3fc);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 1.2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .login-btn {
            background: linear-gradient(90deg, #2563eb, #1e3a8a);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #1d4ed8, #172554);
            transform: scale(1.05);
            color: #fff;
        }

        .badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(37, 99, 235, 0.9);
            color: white;
            font-weight: 500;
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 0.9rem;
        }

        h1 {
            font-weight: 800;
            font-size: 3rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hackathon badge -->
    <div class="badge fade-in">🧠 3MTT Hackathon Demo</div>

    <div class="container fade-in">
        <h1 class="mb-3">FloodVerse</h1>
        <h4 class="text-primary fw-semibold mb-3">Connecting Communities to Safety and Data</h4>

        <p class="lead mb-4">
            A smart flood prediction and resilience platform that saves lives,<br>
            powered by data-driven insights.
        </p>

        <p class="mb-5 fw-medium">
            By <strong>Abwa Wilsmith</strong> & <strong>Ogechukwu Asuzu</strong><br>
            3MTT Cohort 3 Fellows — Hackathon Edition
        </p>

        <a href="{{ url('/admin/login') }}" class="login-btn">Login to Dashboard</a>
    </div>

    <!-- Optional Bootstrap JS (for animation helpers if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
