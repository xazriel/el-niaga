<?php

return [
    'url_tracking'   => env('JNE_URL_TRACKING',   'https://apiv2.jne.co.id:10205'),
    'url_airwaybill' => env('JNE_URL_AIRWAYBILL',  'https://apiv2.jne.co.id:10206'),
    'url_tariff'     => env('JNE_URL_TARIFF',      'https://apiv2.jne.co.id:10205'),
    'username'       => env('JNE_USERNAME'),
    'api_key'        => env('JNE_API_KEY'),
    'origin_code'    => env('JNE_ORIGIN_CODE', 'CGK10000'),
    'branch'         => env('JNE_BRANCH',      'CGK10000'),
    'cust_no'        => env('JNE_CUST_NO',     'TESTAKUN'),
];