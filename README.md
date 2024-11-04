# php-telegram-bot-wrapper

Install using composer :
```console
composer require pierreminiggio/telegram-bot-wrapper
```

```php
use PierreMiniggio\TelegramBotWrapper\AccessTokenProvider;

$provider = new AccessTokenProvider();
$accessToken = $provider->get('yourClientId', 'yourClientSecret', 'yourRefreshToken');
```
