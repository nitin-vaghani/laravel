Laravel Passport

Laravel 5.7 - Create REST API with authentication using Passport Tutorial

Step 1: Install Laravel 5.7

composer create-project --prefer-dist laravel/laravel blog


Step 2: Install Passport

composer require laravel/passport


After successfully install package, we require to get default migration for create new passport tables in our database. so let's run bellow command.

php artisan migrate

Next, we need to install passport using command, Using passport:install command, it will create token keys for security. So let's run bellow command:

php artisan passport:install


=============== SAVE BELOW DETAILS ================
user@developer:/var/www/html/blog$ php artisan passport:install
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: PIkWaa6nwTnseThuCpjrppG0n9urn2XF0JFrynQp
Password grant client created successfully.
Client ID: 2
Client secret: nUSKLORdFfvD4EQoAAAvJWiN9FUO9BeLFGqSBTCo

=============== ======== ================



After successfully install package, open config/app.php file and add service provider.

config/app.php

'providers' =>[

Laravel\Passport\PassportServiceProvider::class,

],

Step 3: Passport Configuration

In this step, we have to configuration on three place model, service provider and auth config file. So you have to just following change on that file.

In User model we added HasApiTokens class of Passport,

In AuthServiceProvider we added "Passport::routes()",

In auth.php, we added api auth configuration.

Follow below given steps : 

app/User.php

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}


app/Providers/AuthServiceProvider.php


<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();
        Passport::routes(); // ADD THIS LINE
    }

}


config/auth.php

<?php


return [

    .....

    'guards' => [

        'web' => [

            'driver' => 'session',

            'provider' => 'users',

        ],

        'api' => [

            'driver' => 'passport', // CHANGE 'token' To 'passport'

            'provider' => 'users',

        ],

    ],
]


Step 4: Add Product Table and Model

php artisan make:migration create_products_table


<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}


php artisan migrate


After create "products" table you should create Product model for products, so first create file in this path app/Product.php and put bellow content in Product.php file:

app/Product.php

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $fillable = [
        'name', 'detail'
    ];

}



Step 5: Create API Routes


routes/api.php

Route::post('register', 'API\RegisterController@register');

Route::middleware('auth:api')->group( function () {
	Route::resource('products', 'API\ProductController');
});


Step 6: Create Controller Files

app/Http/Controllers/API/BaseController.php

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message) {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404) {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

}


app/Http/Controllers/API/ProductController.php


<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Validator;

class ProductController extends BaseController {

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::all();
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
                    'name' => 'required',
                    'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        $input = $request->all();
        $validator = Validator::make($input, [
                    'name' => 'required',
                    'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        return $this->sendResponse($product->toArray(), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $product->delete();
        return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
    }

}


app/Http/Controllers/API/RegisterController.php

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController {

    /**
     * Register api
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'User register successfully.');
    }

}

make sure in details api we will use following headers as listed bellow:


'headers' => [
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
]

Check this postman collection : https://www.getpostman.com/collections/896f74fb7c0bb5a714e6


eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjYyMTg0MDNlZTg5NjQ4YTE2NzM2ZmJhNmYyYTZhMjM5Njc3N2MxMGQyNzFjNWEyYzIyYmM3YjZlMjIzZGYxOTJiYjdiZGFkOGY3Njk1YjNlIn0.eyJhdWQiOiIxIiwianRpIjoiNjIxODQwM2VlODk2NDhhMTY3MzZmYmE2ZjJhNmEyMzk2Nzc3YzEwZDI3MWM1YTJjMjJiYzdiNmUyMjNkZjE5MmJiN2JkYWQ4Zjc2OTViM2UiLCJpYXQiOjE1NDkwMTkwNjQsIm5iZiI6MTU0OTAxOTA2NCwiZXhwIjoxNTgwNTU1MDY0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.PgCPeHCpcfgf3m2hV9W-mJ_rTnatVYkqIqs9B1lkaTih9SacHT0dFN2r5pBYO-JZJZl5f9VnGxLXB3u8qclZ51L4PRnPX-cLcvyoWkVsXOJdRZv2sf8quNwlWJkijn_T0MmxAEn6M6Y8YgBdtoivVd-gOmEgfHNl4c9yvjwiwTx3YEQ3AWthbdgsk6T1XzHsvfxF7ApShtI1roXB56JGn8XLVSGzNQ4LadAjDLD04L6p10ESVgnl30alfO-EwN80eiTFg9vqsKmdsqjB4TfXxI2kGH1Y42e-oiqwAQiZXKtcDPqxmG-HL5PBnGcVjYuTuAvUtne5WqNrnvlRJu0vOoh8wY1jDzU62xhPV-BoBLceQtDQL0zYn3pCamI4csjptS74pyTgErbdRd6HhLmG9pjmETWQjKCFb3pf9INcNtopagCNLJ2vRldxhvDJYcqVhCz4DlG25HzWS7bJBT6Hon-VjgXTfJvgs8qbBw4KT5rox-1mN2QEOkxwTYp1fnFVasODp_EKMmQGKVtArw0hxEWtGqZCTadpVkbMYZLaNt_E9HiT75vrAXl4tCZBtvL4ZXl7R9F8LlW2A4Z_616WIGstO8dx3XTbHQR2ta6LslYxCoxyj5a7Ws68OAM0KWEPU-bDA05kPkNt7OIimlP0skzsT6RnDlJ9Usf4GELqFNg
