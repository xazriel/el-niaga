<?php

return [
    'base_url'    => env('JNE_URL_SANDBOX', 'https://apiv2.jne.co.id:10202'),
    'username'    => env('JNE_USERNAME'),
    'api_key'     => env('JNE_API_KEY'),
    'origin_code' => env('JNE_ORIGIN_CODE', 'DPK10000'),
    'branch'      => env('JNE_BRANCH', 'DPK10000'),
    'cust_no'     => env('JNE_CUST_NO', '80540008'),
];