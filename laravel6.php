<?php
#Laravel 6

/*
Steps for default laravel auth
Step 1:
To get a fresh copy of laravel version 6, fire the following command in your terminal.
*/

composer create-project laravel/laravel laravel6

#> It’ll create a new project in your system.

#NOTE: Remember this command will install laravel version 6 only if you have installed php version >= 7.2.0 in your system.

#Step 2:
#Before you move for the built-in login and registration process you have to install laravel UI as per the new Laravel version. For that fire the following command.

composer require laravel/ui

#Step 3:

#Choose The preset type (bootstrap, vue, react), And hit any one command out of below 3 command

php artisan ui vue --auth
#---------------- OR -------------------
php artisan ui bootstrap --auth
#---------------- OR -------------------
php artisan ui react --auth


#> Laravel 6 has removed “php artisan make:auth” command and instead, they design a new command “php artisan ui vue –auth” for a quick start on login and registration setup process.

#REMEMBER: Here you’ll not find any “css” or “js” folder inside “public” folder of your project, it was created automatically in previous versions of laravel after firing “php artisan make:auth” command for the login and registration pages and other related pages design.

#Now to get a scaffold of CSS and JS file you have to follow the below steps.

#Step 4:
#Fire the following command in terminal

npm install

#> Which will install all the node dependencies in your project.

#Step 5:
#After installing npm, fire the next command

npm run dev

#> As laravel built-in “webpack.min.js” file considers default scaffolding as SASS, you have to run this to make your own scaffolding.

#NOTE: After running “npm run dev” command in terminal you’ll find 2 folders inside your public folder. Which will be “css” and “js” and you’ll find the files inside of it.

#Now just refresh your login url and you’ll find the designed layout.
  
#Thanks
#By Nitinkumar Vaghani
