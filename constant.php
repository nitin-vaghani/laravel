//Laravel constant file


//create constant.php in app/config folder

<?php


return [
    /*
       | Array of all game types
      |
     */
    'game_types' => [
        'treasure_hunt' => 1,
        'fitness_classes' => 2,
        'guided_tours' => 3,
        'quiz' => 4
    ],
    'banned_words' => [
        "aaa",
        "bbb",
        "ccc"
    ]
];


//get data from constant file:

@php 
$banned_words = json_encode(config('constants.banned_words'));
@endphp

        
<script>
var banned_words=JSON.parse('{!! $banned_words!!}');
</script>
