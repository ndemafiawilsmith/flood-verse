# Flood Resilience Project – Laravel 11 + Livewire 3 + Filament 4.0

This project is a community-focused flood resilience app for the 3MTT Hackathon.  
It provides **real-time flood alerts**, **safe zones**, **emergency contacts**, and **safety tips**.  
The stack is **Laravel 11, Livewire 3, and Filament 4.0**, with MySQL as the database.

---

## ✅ Entities & Schema

1. **alerts**
   - id (increments)
   - title (string)
   - message (text)
   - severity (enum: low, medium, high, critical)
   - location (string, nullable)
   - status (boolean, default true)
   - timestamps

2. **safe_zones**
   - id (increments)
   - name (string)
   - description (text, nullable)
   - gps_lat (decimal(10,8))
   - gps_lng (decimal(11,8))
   - address (string)
   - capacity (integer, nullable)
   - timestamps

3. **emergency_contacts**
   - id (increments)
   - name (string)
   - phone (string)
   - role (string)
   - location (string, nullable)
   - timestamps

4. **safety_tips**
   - id (increments)
   - title (string)
   - content (text)
   - language (string, default 'en')
   - timestamps

-------------------------------------------------------------------------------

## 🚀 What Copilot Should Do

- **Migrations**:  
  Generate schema builder code for each table above.  
  Use proper enums, defaults, and indexes where needed.  

- **Models**:  
  Add `$fillable`, `$casts`, and relationships where useful.  

- **Factories** (for demo/testing data):  
  - AlertFactory: fake title, message, severity (enum), location, status.  
  - SafeZoneFactory: fake name, description, lat, lng, address, capacity.  
  - EmergencyContactFactory: fake name, phone, role, location.  
  - SafetyTipFactory: fake title, content, language (pick from ['en', 'ig', 'yo', 'ha']).  

- **Seeders**:  
  Use factories to generate 10–20 records per table for hackathon demo.  

- **Filament 4.0 Resources**:  
  CRUD for all entities with:  
  - Forms (text inputs, selects, textareas, number fields, toggles).  
  - Tables (columns with sorting & searching).  
  - Enum dropdowns for severity and language.  

- **Livewire Components (Frontend UI)**:  
  - `AlertsList`: Show real-time alerts (poll every 30s).  
  - `SafeZonesList`: Show safe zones + map integration.  
  - `EmergencyContactsList`: Directory of contacts.  
  - `SafetyTipsList`: Filterable by language.  

- **Best Practices**:  
  - Use TailwindCSS for quick styling.  
  - Keep code simple and hackathon-ready.  
  - Prioritize functionality over perfection.  

---

## 🛠️ Artisan Commands to Run

```bash```
# Models + Migrations
php artisan make:model Alert -m
php artisan make:model SafeZone -m
php artisan make:model EmergencyContact -m
php artisan make:model SafetyTip -m

# Factories
php artisan make:factory AlertFactory --model=Alert
php artisan make:factory SafeZoneFactory --model=SafeZone
php artisan make:factory EmergencyContactFactory --model=EmergencyContact
php artisan make:factory SafetyTipFactory --model=SafetyTip

# Seeders
php artisan make:seeder AlertSeeder
php artisan make:seeder SafeZoneSeeder
php artisan make:seeder EmergencyContactSeeder
php artisan make:seeder SafetyTipSeeder

# Livewire Components
php artisan make:livewire AlertsList
php artisan make:livewire SafeZonesList
php artisan make:livewire EmergencyContactsList
php artisan make:livewire SafetyTipsList

# Filament Resources (Admin CRUD)
php artisan make:filament-resource Alert --generate
php artisan make:filament-resource SafeZone --generate
php artisan make:filament-resource EmergencyContact --generate
php artisan make:filament-resource SafetyTip --generate
