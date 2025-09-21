set -ex

./vendor/bin/sail artisan make:model Customer --factory --migration
./vendor/bin/sail artisan make:model Employee --factory --migration
./vendor/bin/sail artisan make:model Appointment --factory --migration
./vendor/bin/sail artisan make:model Invoice --factory --migration
./vendor/bin/sail artisan make:model Service --factory --migration
./vendor/bin/sail artisan make:migration create_invoice_service_table --create=invoice_service
