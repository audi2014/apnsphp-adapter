```php
use Audi2014\ApnsAdapter\Apns;
use Audi2014\ApnsAdapter\Fcm;
(new Apns([
    Apns::CONF_APP_CER => 'sandbox.cer',
    Apns::CONF_SANDBOX => true,
]))->sendByTokenArray([
    '***TOKEN***',
    '***TOKEN***',
    '***TOKEN***',
],"adapterSandbox","adapterSandbox");
(new Apns([
    Apns::CONF_APP_CER => 'prod.cer',
    Apns::CONF_SANDBOX => false,
]))->sendByTokenArray([
    '***TOKEN***',
    '***TOKEN***',
    '***TOKEN***',
],"adapterProduction","adapterProduction");
(new Fcm([
    Fcm::CONF_APP_KEY => '**',
]))->sendByTokenArray([
    '***TOKEN***',
    '***TOKEN***',
    '***TOKEN***',
],"adapterFcm","adapterFcm");

```

#how to generate apns pem?

###DEV

`openssl pkcs12 -in server_certificates_bundle_sandbox.p12 -out server_certificates_bundle_sandbox.pem -nodes -clcerts`

###PROD

`openssl pkcs12 -in server_certificates_bundle_production.p12 -out server_certificates_bundle_production.pem -nodes`