Steps to add Localization in laravel

1. Run the following command in order to create the required middleware.

php artisan make:middleware Localization

2. Then open it. The file should be in "project_name/app/Http/Middleware/Localization.php"
Update the code that is present with the one below : 

public function handle($request, Closure $next)
{
   if(\Session::has('locale'))
   {
       \App::setlocale(\Session::get('locale'));
   }
   return $next($request);
}

3.  Lets say you want your website to be in English and French. 

   1. Go to "project_name/resources/lang/en/"
   2. Create a file name "messages.php"
   3. Create folder "fr" in "project_name/resources/lang/"
   4. Create a file name "messages.php" in "project_name/resources/lang/fr/"

4. Open "messages.php" in both folder and insert the following codes.
"messages.php" in 'en' folder. 

return [
    'welcome'       => 'Welcome to our application'
];

5. Open "messages.php" in 'fr' folder. 

return [
    'welcome'       => 'Bienvenue sur notre application'
];

6. Most important...

Add the below codes in "project_name/app/Http/Kernel.php" in "protected $middlewareGroups section".

\App\Http\Middleware\Localization::class,

7. So your codes should be like this :

protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\Localization::class, // ADD THIS LINE
        ],
    ];

8. Now all this code in the route, "project_name/routes/web.php" on top of other defined routes.
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

9. So in order to know the language that is being use, you can simply use :
<html lang="{{ app()->getLocale() }}">

10. Changing language en/fr

To change the language, just create an anchor tag in html like the following : 

<li><a href="{{ url('locale/en') }}" ><i class="fa fa-language"></i> EN</a></li>

<li><a href="{{ url('locale/fr') }}" ><i class="fa fa-language"></i> FR</a></li>

11. To call the desired text :

<h1>{{ __('messages.welcome') }}</h1>

That's it. END....

But best method is to set a custom If Statement!

1: Add in your AppServiceProvider:

use Illuminate\Support\ServiceProvider;

public function boot()
{   
    Blade::if('lang', function ($language) {
        return app()->isLocale($language);
    });
}

2: In your views:

@lang('en')
     <h1>{{ __('messages.welcome') }}</h1>
@elselang('ar')
     <h1>{{ __('messages.welcome') }}</h1>
@else
     <h1>{{ __('messages.welcome') }}</h1>
@endlang


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

https://dev.to/fadilxcoder/adding-multi-language-functionality-in-a-website-developed-in-laravel-4ech

************** Retrieving Translation Strings ******************

echo __('messages.welcome');

echo __('I love programming.');


************** If you are using the Blade templating engine, you may use the {{ }} syntax to echo the translation string or use the @lang directive: *************

{{ __('messages.welcome') }}

@lang('messages.welcome')


************** Replacing Parameters In Translation Strings ************

in language file: 
'welcome' => 'Welcome, :name',

While print message :
echo __('messages.welcome', ['name' => 'dayle']);


@if (app()->isLocale('en'))
  //
@endif
