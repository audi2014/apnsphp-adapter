#how to generate apns pem?

###DEV

`openssl pkcs12 -in server_certificates_bundle_sandbox.p12 -out server_certificates_bundle_sandbox.pem -nodes -clcerts`

###PROD

`openssl pkcs12 -in server_certificates_bundle_production.p12 -out server_certificates_bundle_production.pem -nodes`