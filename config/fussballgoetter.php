<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Training
    |--------------------------------------------------------------------------
    |
    | Wochentag (1 = Montag … 7 = Sonntag) und Uhrzeit, an dem automatisch
    | das nächste Training angelegt wird, wenn keines mehr in der Zukunft liegt.
    |
    */

    'practise' => [
        'name' => 'Fußballgötter',
        'weekday' => 1,
        'time' => '19:30',
        'location' => 'Sportplatz am Ardey',
        'maps_url' => 'https://www.google.de/maps/dir/M%C3%A4dchen-+und+Frauen-+Fu%C3%9Fball+Club+Soest,+Ardeyweg+33,+59494+Soest/M%C3%A4dchen-+und+Frauen-+Fu%C3%9Fball+Club+Soest,+Ardeyweg+33,+59494+Soest/@51.5727613,8.0817294,15z/data=!4m14!4m13!1m5!1m1!1s0x47b962c855e7097f:0x85986edeaed34887!2m2!1d8.0788334!2d51.5720021!1m5!1m1!1s0x47b962c855e7097f:0x85986edeaed34887!2m2!1d8.0788334!2d51.5720021!3e0?entry=ttu&g_ep=EgoyMDI2MDQwOC4wIKXMDSoASAFQAw%3D%3D',
        // Minuten vor Anpfiff, zu denen man sich trifft.
        'meet_minutes_before' => 15,
        // Stunden vor Anpfiff, bis zu denen An-/Abmeldung möglich ist.
        'registration_deadline_hours' => 4,
        // Stunden vor Anpfiff, ab denen die Teams gelost werden dürfen.
        'draw_opens_hours_before' => 3,
        // Stunden nach Anpfiff, für die das Training noch als "aktuell" gilt.
        'visible_hours_after' => 4,
        // Ab dieser Teilnehmerzahl werden drei statt zwei Teams gelost.
        'three_teams_from' => 15,
    ],

    /*
    |--------------------------------------------------------------------------
    | Berechtigungen
    |--------------------------------------------------------------------------
    */

    // Namen der Benutzer, die die Teams auslosen dürfen.
    'drawers' => ['T-Man', 'Übungsleiter'],

    /*
    |--------------------------------------------------------------------------
    | Optionale Funktionen
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        // Stunden vor Ablauf der Anmeldefrist, zu denen Unentschlossene per Push erinnert werden.
        'reminder_hours_before_deadline' => [24, 3],
    ],

    'features' => [
        // "Ich bringe Bier mit"
        'beer' => (bool) env('FEATURE_BEER', false),
        // Fahrgemeinschaften (Fahrer / Mitfahrer)
        'carpool' => (bool) env('FEATURE_CARPOOL', false),
    ],

];
