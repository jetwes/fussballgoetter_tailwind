# Fußballgötter App

Diese Laravel-App ermöglicht es, regelmäßige Trainings einer (Hobby-)Sportgruppe zu verwalten. Der Name ist durch unsere Hobby-Gruppe entstanden.

## Funktionen

* Spieler können sich für das nächste Training an- und abmelden (bis zu einer konfigurierbaren Frist).
* Das nächste Training wird automatisch angelegt (Wochentag und Uhrzeit konfigurierbar).
* Ausgewählte Benutzer können kurz vor dem Training die Teams auslosen (2 oder 3 Teams).
* Geburtstage der nächsten Tage werden angezeigt.
* Optional: „Ich bringe Bier mit“ und Fahrgemeinschaften (Fahrer/Mitfahrer), per `.env` aktivierbar.
* Profil mit Foto (wird automatisch zugeschnitten), Name, Geburtstag und Passwort.
* Hell/Dunkel-Modus, mobil optimiert, als PWA installierbar.

## Technik

* [Laravel 13](https://laravel.com) (PHP 8.3+)
* [Livewire 4](https://livewire.laravel.com) mit [Flux UI](https://fluxui.dev) (kostenlose Komponenten)
* [Tailwind CSS 4](https://tailwindcss.com) über Vite
* MySQL-kompatible Datenbank (lokal und in Tests auch SQLite)
* [Pest 4](https://pestphp.com) für Tests

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Für die Entwicklung startet `composer run dev` den Server, den Queue-Worker, Logs und Vite gleichzeitig.

### Konfiguration

Alle App-spezifischen Einstellungen liegen in `config/fussballgoetter.php`:

* Trainingstag, Uhrzeit, Ort und Routen-Link
* Anmeldefrist und Zeitfenster für die Auslosung
* Namen der Benutzer, die auslosen dürfen
* Optionale Funktionen (`FEATURE_BEER`, `FEATURE_CARPOOL` in der `.env`)

### Tests

```bash
php artisan test
```

Die Tests laufen gegen eine SQLite-Datenbank im Arbeitsspeicher.
