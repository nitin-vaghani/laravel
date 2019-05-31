<?php

//Access another controller method using current controller

$request->merge(['quiz_id' => $value['game_id']]);

$controller = new \App\Http\Controllers\api\v1\QuizController($this->game_service, $this->venue_service);

dd($controller->getQuizInfo($request));
