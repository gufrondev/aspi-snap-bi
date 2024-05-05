# ASPI SNAP BI
Multi-Providers (banks) ASPI SNAP BI Package

### Features
[x] Internal Bank Inquiry
[x] External Bank Inquiry
[x] Transfer Intrabank
[x] Transfer Interbank
[x] Transfer RTGS
[x] Transfer SKN
[] VA Payment webhook
[] VA Inquery webhook
[] External VA Payment
[] External VA Inquiry

### Instalation
```
composer require gufrondev/aspi-snap-bi
```
Publish the config file
```
php artisan vendor:publish --tag=aspi-snap-bi
```

### Usage
Include the namespace each time you use this library.
```php
use GufronDev\AspiSnapBI\SnapBiClient;
```

There is one required parameter called "provider" when you initialize the library
```
provider = aspi, danamon, bca, bri or etc
``` 

***Internal Account Inquiry***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->internalAccountInquiry([
    'beneficiaryAccountNo' => '2000100101',
    'partnerReferenceNo' => '2020102900000000000001',
    'additionalInfo' => [
        'deviceId' => '12345679237',
        'channel' => 'mobilephone'
    ]
]);
```

***External Account Inquiry***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->externalAccountInquiry([
    'beneficiaryBankCode' => '008',
    'beneficiaryAccountNo' => '8000800808',
    'partnerReferenceNo' => '2020102900000000000001',
    'additionalInfo' => [
        'deviceId' => '12345679237',
        'channel' => 'mobilephone'
    ]
]);
```

***Transfer Intrabank***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->transfer([
    'partnerReferenceNo' => '2020102900000000000001',
    'amount' => [
        'value' => 12345678.00,
        'currency' => 'IDR'
    ],
    'beneficiaryAccountNo' => '2000100101',
    'currency' => 'IDR',
    'customerReference' => '10052019',
    'feeType' => 'BEN',
    'remark' => 'remark test',
    'sourceAccountNo' => '2000200202',
    'transactionDate' => date(DATE_ATOM, time()),
    'additionalInfo' => [
        'deviceId' => '12345679237',
        'channel' => 'mobilephone'
    ]
], 'intrabank');
```

***Transfer Interbank***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->transfer([
    'partnerReferenceNo' => '2020102900000000000001',
    'amount' => [
        'value' => 12345678.00,
        'currency' => 'IDR'
    ],
    'beneficiaryAccountName' => 'Yories Yolanda',
    'beneficiaryAccountNo' => '8000800808',
    'beneficiaryBankCode' => '008',
    'currency' => 'IDR',
    'customerReference' => '10052019',
    'feeType' => 'OUR',
    'sourceAccountNo' => '2000200202',
    'transactionDate' => date(DATE_ATOM, time()),
    'additionalInfo' => [
        'deviceId' => '12345679237',
        'channel' => 'mobilephone'
    ]
], 'interbank');
```

***Transfer RTGS***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->transfer([
    'partnerReferenceNo' => '2020102900000000000001',
    'amount' => [
        'value' => 12345678.00,
        'currency' => 'IDR'
    ],
    'beneficiaryAccountName' => 'Yories Yolanda',
    'beneficiaryAccountNo' => '8000800808',
    'beneficiaryAddress' => 'Palembang',
    'beneficiaryBankCode' => '008',
    'beneficiaryBankName' => 'Bank BRI',
    'beneficiaryCustomerResidence' => 1,
    'beneficiaryCustomerType' => 1,
    'beneficiaryEmail' => 'yories.yolanda@work.bri.co.id',
    'currency' => 'IDR',
    'customerReference' => '10052019',
    'feeType' => 'BEN',
    'kodepos' => '12250',
    'receiverPhone' => '080901020304',
    'remark' =>'remark test',
    'senderCustomerResidence' => 1,
    'senderCustomerType' => 1,
    'senderPhone' => '080901020304',
    'sourceAccountNo' => '2000200202',
    'transactionDate' => date(DATE_ATOM, time()),
    'additionalInfo' => [
        'deviceId' => '12345679237',
        'channel' => 'mobilephone'
    ]
], 'rtgs');
```

***Transfer SKN***
```php
$snap = new SnapBiClient(
    provider: 'aspi'
);
$response = $snap->transfer([
    "partnerReferenceNo" =>"2020102900000000000001",
    "amount" =>[
        "value" =>"12345678.00",
        "currency" =>"IDR"
    ],
    "beneficiaryAccountName" =>"Yories Yolanda",
    "beneficiaryAccountNo" =>"8000800808",
    "beneficiaryAddress" =>"Palembang",
    "beneficiaryBankCode" =>"008",
    "beneficiaryBankName" =>"Bank BRI",
    "beneficiaryCustomerResidence" =>"1",
    "beneficiaryCustomerType" =>"1",
    "beneficiaryEmail" =>"yories.yolanda@work.bri.co.id",
    "currency" =>"IDR",
    "customerReference" =>"10052019",
    "feeType" =>"BEN",
    "kodepos" =>"12250",
    "receiverPhone" =>"080901020304",
    "remark" =>"remark test",
    "senderCustomerResidence" =>"1",
    "senderCustomerType" =>"1",
    "senderPhone" =>"080901020304",
    "sourceAccountNo" =>"2000200202",
    "transactionDate" => date(DATE_ATOM, time()),
    "additionalInfo" =>[
        "deviceId" =>"12345679237",
        "channel" =>"mobilephone"
    ]
    ], 'skn');
```

### Configuration
Located at after publish
```
config/snapbi.php
```

***Configuration***
```php
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
```