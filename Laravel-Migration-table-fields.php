<?php

$table->bigIncrements('u_id');
$table->decimal('u_price', 11, 8);
$table->boolean('active')->default(true);
$table->string('username')->unique();
$table->text('icon');
$table->string('u_image')->nullable();
$table->integer('game_type_id')->unsigned();
$table->integer('venues_id')->unsigned()->nullable();
$table->string('answer')->default('');
$table->string('email')->nullable()->comment = "Null when new family member is added.";
$table->string('name', 120)->nullable()->comment = "Name of the admin added through the settings page.";
$table->tinyInteger('status')->default(0)->comment = "Activity status: 1 - active, 0 - deactivated";
$table->boolean('is_checked')->default(0);
$table->timestamp('u_created_at')->nullable();
$table->timestamp('u_updated_at')->nullable();
$table->enum('udt_device_type', ['android', 'ios'])->default('android');

$table->softDeletes();

$table->foreign('game_type_id')
        ->references('id')
        ->on('game_type')
        ->onDelete('cascade');

$table->foreign('venues_id')
        ->references('id')
        ->on('venues')
        ->onDelete('cascade');


$table->index('user_name');

$table->foreign('badge_id')->references('id')->on('badges');
$table->foreign('venue_id')->references('id')->on('venues');
$table->primary(['badge_id', 'venue_id']);


//php artisan migrate --force
