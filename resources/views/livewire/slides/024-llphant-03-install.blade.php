<x:slide>
Install:
```
composer require theodo-group/llphant:dev-main
```

Generate text response
```php
$chat = new OpenAIChat();
```

Set system message
```php
$chat->setSystemMessage('You are a helpful assistant.');
```

Generate text response or a stream
```php
$response = $chat->generateText('Write a haiku about Laravel.');
// or
$stream = $chat->generateStreamOfText('Write a haiku about Laravel.');
```
</x:slide>
