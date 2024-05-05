<?php

return [
    'aspi' => [
        'url' => env('SNAP_BI_ASPI_URL'),
        'res' => env('SNAP_BI_ASPI_RES'),
        'version' => env('SNAP_BI_ASPI_VERSION'),
        'client_id' => env('SNAP_BI_ASPI_CLIENT_ID'),
        'client_secret' => env('SNAP_BI_ASPI_CLIENT_SECRET'),
        'public_key' => env('SNAP_BI_ASPI_PUBLIC_KEY'),
        'secret_key' => env('SNAP_BI_ASPI_SECRET_KEY'),
        'is_physical_keys' => false,
        'use_proxy' => false,
        'proxy_ip' => env('SNAP_BI_ASPI_PROXY_IP'),
        'proxy_port' => env('SNAP_BI_ASPI_PROXY_PORT'),
        'proxy_username' => env('SNAP_BI_ASPI_PROXY_USERNAME'),
        'proxy_password' => env('SNAP_BI_ASPI_PROXY_PASSWORD'),
        'channel_id' => env('SNAP_BI_ASPI_CHANNEL_ID'),
        'external_id' => env('SNAP_BI_ASPI_EXTERNAL_ID'),
    ],
    'danamon' => [
        'url' => env('SNAP_BI_DANAMON_URL'),
        'res' => env('SNAP_BI_DANAMON_RES'),
        'version' => env('SNAP_BI_DANAMON_VERSION'),
        'client_id' => env('SNAP_BI_DANAMON_CLIENT_ID'),
        'client_secret' => env('SNAP_BI_DANAMON_CLIENT_SECRET'),
        'public_key' => env('SNAP_BI_DANAMON_PUBLIC_KEY'),
        'secret_key' => env('SNAP_BI_DANAMON_SECRET_KEY'),
        'is_physical_keys' => true,
        'use_proxy' => true,
        'proxy_ip' => env('SNAP_BI_DANAMON_PROXY_IP'),
        'proxy_port' => env('SNAP_BI_DANAMON_PROXY_PORT'),
        'proxy_username' => env('SNAP_BI_DANAMON_PROXY_USERNAME'),
        'proxy_password' => env('SNAP_BI_DANAMON_PROXY_PASSWORD'),
        'channel_id' => env('SNAP_BI_DANAMON_CHANNEL_ID'),
        'external_id' => env('SNAP_BI_DANAMON_EXTERNAL_ID'),
    ]
];
