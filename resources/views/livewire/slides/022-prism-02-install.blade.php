<x:slide>
Installation:
```
composer require echolabsdev/prism
```
.env
```
OPENAI_API_KEY=
```
PHP code:
```php
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Enums\Provider;
$response = Prism::text()
    ->using(Provider::OpenAI, 'gpt-4o')
    ->withMessages([new UserMessage($prompt)])
    ->generate();
return $response->text;
```
</x:slide>
