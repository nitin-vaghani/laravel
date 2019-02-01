<?php

//Laravel migrations

//Create new table : 
php artisan make:migration create_products_table --create="products"

//Update migration into database : 
php artisan migrate

//Refresh migration into database :  
php artisan migrate:refresh

//Create a new migration using :
php artisan migrate:make update_users_table.

//Composer dump if autoload error : 
composer dump-autoload


//Update migration file : 
php artisan make:migration update_providers_table --table=providers

//run : 
php artisan migrate

//Note: data will be remain

php artisan make:migration create_oauth_access_tokens_table --create="oauth_access_tokens"
php artisan make:model Reports -mcr
php artisan make:model VitalSignatureFollowUp -m


/*
if you run php artisan make:model --help you can see all the available options

    -m, --migration Create a new migration file for the model.

    -c, --controller Create a new controller for the model.

    -r, --resource Indicates if the generated controller should be a resource controller

*/
