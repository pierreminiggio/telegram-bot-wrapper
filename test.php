<?php

use PierreMiniggio\TelegramBotWrapper\TelegramBot;

$projectDirectory = __DIR__ . DIRECTORY_SEPARATOR;

require $projectDirectory . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = require $projectDirectory . 'config.php';

$bot = new TelegramBot($config['bot']);
$messageId = $bot->sendMessageToChat($config['chatId'], 'Test wrapper');
var_dump($messageId);
