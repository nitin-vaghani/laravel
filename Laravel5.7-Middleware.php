<?php
//Laravel Middleware

// Example of create custom app access token for each api request

//Create /var/www/html/blog/app/Http/Middleware/IsAppUser.php file

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class IsAppUser {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
            $token = !empty($request->header('appaccesstoken')) ? $request->header('appaccesstoken') : null;
            if ($request->ajax() || empty($token) || $token != 'A7UHTE#3943=T@b^Nbdhb7s3Sf_v@p_B') {
                return response()->json([
                            'success' => false,
                            'message' => 'Unauthorized.',
                            'code' => 401,
                            'result' => ''
                                ], 401);
            }

        return $next($request);
    }

}


// Register your middleware in /var/www/html/blog/app/Http/Kernel.php file

 protected $routeMiddleware = [
        'isAppUser' => \App\Http\Middleware\IsAppUser::class,
];


// Bind Middleware in /var/www/html/blog/routes/api.php file

Route::group(['middleware' => ['isAppUser']], function (Router $router) {
// Write all routes inside this scope
});
