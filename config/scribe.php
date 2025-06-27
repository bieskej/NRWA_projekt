<?php

use Knuckles\Scribe\Extracting\Strategies;

return [
    // The HTML <title> for the generated documentation. If this is empty, Scribe will infer it from config('app.name').
    'title' => null,

    // A short description of your API. Will be included in the docs webpage, Postman collection and OpenAPI spec.
    'description' => '',

    // The base URL displayed in the docs. If this is empty, Scribe will use the value of config('app.url') at generation time.
    'base_url' => null,

    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'],
                'domains' => ['*'],
                'versions' => ['v1'],
            ],
            'include' => [],
            'exclude' => [],
        ],
    ],
    
    'type' => 'static',

    'theme' => 'default',

    'static' => [
        'output_path' => 'public/docs',
    ],

    'laravel' => [
        'add_routes' => true,
        'docs_url' => '/docs',
        'assets_directory' => null,
        'middleware' => [],
    ],

    'external' => [
        'html_attributes' => []
    ],

    'try_it_out' => [
        // Omogućava "Try It Out" funkcionalnost
        'enabled' => true,
        'base_url' => null,
        // Ključno za Sanctum: govori Scribe-u da zatraži CSRF kolačić
        'use_csrf' => true,
        'csrf_url' => '/sanctum/csrf-cookie',
    ],

    // Postavke za autentifikaciju
    'auth' => [
        // Glavni prekidač za autentifikaciju
        'enabled' => true,
        // Govori Scribe-u da su sve rute zaštićene po defaultu
        'default' => true,
        // KLJUČNA LINIJA: Metoda autentifikacije za Sanctum
        'in' => 'cookie',
        // Ime je formalnost za 'cookie' metodu
        'name' => 'XSRF-TOKEN',
        // Ostaviti na null, Scribe ovo rješava automatski
        'use_value' => null,
        // Placeholder se ne prikazuje za 'cookie' metodu
        'placeholder' => 'Autentifikacija se obavlja automatski.',
        // Upute za korisnika
        'extra_info' => 'Ova API koristi cookie autentifikaciju. Kliknite "Authenticate" da se prijavite.',
    ],

    'intro_text' => <<<INTRO
This documentation aims to provide all the information you need to work with our API.

<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
INTRO,

    'example_languages' => [
        'bash',
        'javascript',
    ],

    'postman' => [
        'enabled' => true,
        'overrides' => [],
    ],

    'openapi' => [
        'enabled' => true,
        'overrides' => [],
    ],

    'groups' => [
        'default' => 'Endpoints',
        'order' => [],
    ],
    
    'logo' => false,
    
    'last_updated' => 'Last updated: {date:F j, Y}',
    
    'examples' => [
        'faker_seed' => null,
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],

    'strategies' => [
        'metadata' => [
            Strategies\Metadata\GetFromDocBlocks::class,
            Strategies\Metadata\GetFromMetadataAttributes::class,
        ],
        'urlParameters' => [
            Strategies\UrlParameters\GetFromLaravelAPI::class,
            Strategies\UrlParameters\GetFromUrlParamAttribute::class,
            Strategies\UrlParameters\GetFromUrlParamTag::class,
        ],
        'queryParameters' => [
            Strategies\QueryParameters\GetFromFormRequest::class,
            Strategies\QueryParameters\GetFromInlineValidator::class,
            Strategies\QueryParameters\GetFromQueryParamAttribute::class,
            Strategies\QueryParameters\GetFromQueryParamTag::class,
        ],
        'headers' => [
            Strategies\Headers\GetFromHeaderAttribute::class,
            Strategies\Headers\GetFromHeaderTag::class,
            ['override', ['Content-Type' => 'application/json', 'Accept' => 'application/json']]
        ],
        'bodyParameters' => [
            Strategies\BodyParameters\GetFromFormRequest::class,
            Strategies\BodyParameters\GetFromInlineValidator::class,
            Strategies\BodyParameters\GetFromBodyParamAttribute::class,
            Strategies\BodyParameters\GetFromBodyParamTag::class,
        ],
        'responses' => [
            Strategies\Responses\UseResponseAttributes::class,
            Strategies\Responses\UseTransformerTags::class,
            Strategies\Responses\UseApiResourceTags::class,
            Strategies\Responses\UseResponseTag::class,
            Strategies\Responses\UseResponseFileTag::class,
            [
                Strategies\Responses\ResponseCalls::class,
                ['config' => ['app.debug' => false,],]
            ]
        ],
        'responseFields' => [
            Strategies\ResponseFields\GetFromResponseFieldAttribute::class,
            Strategies\ResponseFields\GetFromResponseFieldTag::class,
        ],
    ],
    
    'database_connections_to_transact' => [config('database.default')],
    
    'fractal' => [
        'serializer' => null,
    ],
    
    'routeMatcher' => \Knuckles\Scribe\Matching\RouteMatcher::class,
];
