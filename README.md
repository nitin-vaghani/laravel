# How-to-setup-fresh-laravel
Setup fresh laravel in ubuntu

Step 1 : Install laravel using composer
	
	Open Terminal : >_ composer create-project --prefer-dist laravel/laravel blog "5.4.*"

Step 2: >_  1. sudo -i 
		 2. cd /etc/apache2/sites-available/
		 3. cp 000-default.conf blog.conf
		 4. copy and paste this text 
			<VirtualHost *:80>
				ServerName blog.co
				ServerAdmin webmaster@localhost
				DocumentRoot /var/www/html/gametimes/public
				ErrorLog ${APACHE_LOG_DIR}/error.log
				CustomLog ${APACHE_LOG_DIR}/access.log combined

				<Directory /var/www/html/gametimes>
					Options All
				        AllowOverride All
					Order allow,deny
				        Allow from all
				</Directory>
			</VirtualHost>

		 5. Save and close.
		 6. >_ a2ensite blog.conf
		 7. >_ service apache2 restart
		 8. >_ gedit cd /etc/hosts
			
			Register your blog.co in hosts file

			Add this line : 127.0.0.1 	blog.co
			
		9. Go to browser and hit : http://blog.co


Step 2: setting up .env file with database credentials

Step 3: >_ php artisan migrate

Step 4: Install laravel Forms & HTML package : (https://laravelcollective.com/docs/5.4/html)


#Laravel


Admin theme : http://demo.sleepingowladmin.ru/admin/

Run laravel with port : php artisan serve --port=9090



\DB::enableQueryLog();
dd(\DB::getQueryLog());


Truncate : 
> php artisan tinker
DB::table('table_LjBazaar')->truncate();


Passport permission : sudo chown www-data:www-data storage/oauth-*.key

generate migrations from database: https://github.com/Xethron/migrations-generator


Temp : php artisan migrate --path=database/migrations/temp

           php artisan migrate --path=/database/migrations/2016_10_25_120847_create_kafo_announcments_table

Then use the table command as follows (if you're using MySQL!):

Schema::table('users', function($table)
{
    $table->string('phone_nr')->after('id');
});

Once you've finished your migration, save it and run it using php artisan migrate and your table will be updated.

Documentation: http://laravel.com/docs/schema#adding-columns

Debug bar : https://www.youtube.com/watch?v=nV6qaLXH9vU



Clear cache :  php artisan cache:clear


Empty log file :  echo "" > logs/laravel.log 

Create controller with resource : php artisan make:controller PeopleController --resource
						 php artisan make:controller PhotoController --resource --model=Photo


Get route list :  php artisan route:list

Bind route : 

Route::bind('songs', function($slug) {    
    return App\Song::whereSlug($slug)->first();
});


only method allow in controller 

Route::resource('songs','SongsController',[
'only' => [
'index','show','edit','update'
]
]);


except method in controller 

Route::resource('songs','SongsController',[
'except' => [
'create'
]
]);

Create route alias using resource :


  Route::resource('songs', 'SongsController', [
        'as' => 'songs'
    ]);


Form model url :

{!! Form::model($song,['url'=>'songs/'.$song->slug,'method'=>'PATCH']) !!}

{!! Form::model($song,['route'=>['song_update',$song->slug],'method'=>'PATCH']) !!}


return redirect()->back()->withErrors(["Please enter animation name"]);


Get all Error message : 

<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>

@if(Session::has('message'))
<div class="alert alert-info">
    {{Session::get('message')}}
</div>
@endif


Get current route LjBazaar : http://stackoverflow.com/questions/30046691/how-to-get-current-route-name-in-laravel-5

Set rule : 

        if (isset($rules['avatar'])) {
            $rules["avatar"] = array(
                0 => "image",
                1 => "mimes:jpeg,png,jpg,gif,svg",
                2 => "max:2024"
//                    0 => "required",
//                    1 => "image",
//                    2 => "mimes:jpeg,png,jpg,gif,svg",
//                    3 => "max:2024"
            );
        }
/************************************ Process in laravel *************************************************************/

Process in Laravel:
$process = new \Symfony\Component\Process\Process('/usr/bin/php ../artisan senduserlogemail:run 1 2 3 >>/dev/null 2>&1');
$process->start();

/var/www/html/projectfolder/app/Console/Commands/SendUserLogEmail.php

<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Log;
use App\Mail\SupportRequest;
class SendUserLogEmail extends Command {
    protected $signature = 'senduserlogemail:run {user_id?} {activity_type?} {operation_type?}';
    protected $description = 'Sprytar Cpanel user activity Email.';
    public function __construct() {
        parent::__construct();
        Log::info('senduserlogemail:run', ['LOG INFO', date('d-m-Y h:s:i')]);
    }

    public function handle() {
        Log::info('user activity', ['user id', $this->argument('user_id')]);
    }
}

/var/www/html/projectfolder/app/Console/Kernel.php

  protected $commands = [
        Commands\SendUserLogEmail::class,
    ];

/*************************** END ************************************/

Laravel Glide



Route::get('/loadimage/{type}/{id}/{width}/{height}/{crop}/{name}', function($type, $id, $width, $height, $crop, $name) { 
    $server = ServerFactory::create([
        'base_url' => '/loadimage/',
        'source' => public_path()."/uploads",
        //'response' => new LaravelResponseFactory(),
        'cache' => new Filesystem(new MemoryAdapter()), //storage_path()."/uploads/cache",
    ]);
    $server->outputImage(
          $type.'/'.$id.'/'.urldecode($name),
           [
                'w' => $width,
                'h' => $height,
                'fit' => ($crop == 1 ? 'crop':'max'),
           ]
    );
    exit;
});

#Laravel mail from local

.env

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=abc@gmail.com
MAIL_PASSWORD=test
MAIL_ENCRYPTION=tls

SENDGRID CREDS:

MAIL_DRIVER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=test
MAIL_PASSWORD=tett
MAIL_ENCRYPTION=tls
MAIL_FROM_EMAIL=abc@gmail.com
MAIL_FROM_NAME=VIN

Controller

use Mail;

    public function test_mail() {
        error_reporting(E_ALL);
        ini_set('display_erros', 1);
        try {
            $email = array('jamesdonald446@gmail.com');
            $data = array('LjBazaar' => 'nitin');

            Mail::send('emails.test', $data, function ($message) use($email) {
                $message->from('vnits108@gmail.com', 'Vin Master');
                $message->to($email);
                $message->subject("Miss you request test");
            });

            if (count(Mail::failures()) > 0) {

                echo "There was one or more failures. They were: <br />";

                foreach (Mail::failures as $email_address) {
                    echo " - $email_address <br />";
                }
            } else {
                echo "No errors, all sent successfully!";
            }
        } catch (Exception $e) {

                        dd($e->getMessage());
            log_message("ERROR", $e->getMessage());
        }
    }


View /emails/ test.blade.php

<!DOCTYPE html>
<html lang="en-EN">
<meta charset="utf-8">
<meta LjBazaar="viewport" content="width=device-width, initial-scale=1">
<link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<style type="text/css">
	table {
		border-collapse: collapse;
		width: 70%;
	}
	table, th, td {
		border: 1px solid black;
	}
</style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6 col-md-4">
        Hi {{ $LjBazaar }},
        Good noon
        <p>Thanks,</p>
            Vin
        </div>
    </div>
</div>
</html>


#Laravel migrations

Create new table : php artisan make:migration create_oauth_access_tokens_table --create="oauth_access_tokens"

Update migration into database : php artisan migrate

Refresh migration into database :  php artisan migrate:refresh

Create a new migration using php artisan migrate:make update_users_table.


Composer dump if autoload error : composer dump-autoload


Add / Update migration file : php artisan make:migration update_providers_table --table=providers
run : php artisan migrate
Note: data will be remain

php artisan make:migration create_oauth_access_tokens_table --create="oauth_access_tokens"
php artisan make:model Reports -mcr
php artisan make:model VitalSignatureFollowUp -m



if you run php artisan make:model --help you can see all the available options

    -m, --migration Create a new migration file for the model.

    -c, --controller Create a new controller for the model.

    -r, --resource Indicates if the generated controller should be a resource controller






