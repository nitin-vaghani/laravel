#Laravel Log Channgel


#/config/logging.php

'import' => [
           'driver' => 'single',
           'path' => public_path('logs/import.log'),
           'level' => 'debug',
],


Log::channel('import')->info("Hii");

