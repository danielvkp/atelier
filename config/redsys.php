<?php

return [
    'currency' => '978',
    'terminal' => '1',
    'transactionType' => '0',
    'language' => '1',
    'merchantCode' => env('REDSYS_MERCHANT_CODE'),
    'merchantName' => env('REDSYS_MERCHANT_NAME', 'Equilibrio y mente'),
    'merchantUrl' => env('REDSYS_MERCHANT_URL',  env('APP_URL') . 'pago/notificacion'),
    'urlOk' => env('REDSYS_URL_OK', env('APP_URL') . 'pago/completado'),
    'urlKo' => env('REDSYS_URL_KO',  env('APP_URL') . 'pago/error'),
    'environments' => [
        'test' => [
            'secretKey' => 'sq7HjrUOBfKmC576ILgskD5srU870gJ7',
            'serviveUrl' => 'https://sis-t.redsys.es:25443/sis/realizarPago',
        ],
        'live' => [
            'secretKey' => 'GIeVi8gnZkZ3hq9m3sHX9UYxbEXcsn5E',
            'serviveUrl' => 'https://sis.redsys.es/sis/realizarPago',
        ]
    ]
];
