<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'buffer' => [
        'version' => '6.0.3',
    ],
    'base64-js' => [
        'version' => '1.5.1',
    ],
    'ieee754' => [
        'version' => '1.2.1',
    ],
    'diacritics' => [
        'version' => '1.3.0',
    ],
    'fuzzyset' => [
        'version' => '1.0.7',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'htmx.org' => [
        'version' => '1.9.12',
    ],
];
