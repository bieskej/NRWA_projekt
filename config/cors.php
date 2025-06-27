<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Ovdje se podešavaju postavke za "cross-origin resource sharing" (CORS).
    | Ovo određuje koje cross-origin operacije se mogu izvršavati u preglednicima.
    | Slobodno prilagodi ove postavke po potrebi.
    |
    | Više na: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Definišemo putanje na koje se primjenjuju ova CORS pravila.
    // Uključujemo sve API rute, Sanctum, login, logout i GitHub rute.
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'auth/github/*'],

    // Dozvoljavamo sve HTTP metode (GET, POST, PUT, DELETE, itd.).
    'allowed_methods' => ['*'],

    // Ključna linija za lokalni razvoj:
    // Dozvoljavamo zahtjeve s BILO KOJE domene. Ovo eliminiše sve probleme.
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    // Dozvoljavamo sve headere u zahtjevu.
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // NAJVAŽNIJA POSTAVKA:
    // Omogućava slanje "credentials" (osjetljivih podataka) poput kolačića.
    // Ovo je obavezno za Sanctum i Scribe autentifikaciju.
    'supports_credentials' => true,

];
