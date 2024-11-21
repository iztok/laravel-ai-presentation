<?php

use function Livewire\Volt\{state, mount};
use RakibDevs\Weather\Weather;
use LLPhant\Chat\AnthropicChat;
use LLPhant\Chat\FunctionInfo\Parameter;
use LLPhant\Chat\FunctionInfo\FunctionInfo;

class WeatherService {
    public function currentWeatherForLocation($location) {
        $wt = new Weather();
        $info = $wt->getCurrentByCity($location);
        return json_encode($info);
    }
}

state([
    'prompt' => 'What is the weather in Ljubljana',
    'result' => '',
    'history' => null,
]);

$getReply = function () {
    $chat = new AnthropicChat();
    $location = new Parameter('location', 'string', 'the name of the city, the state or province and the nation');
    $weatherService = new WeatherService();


    $function = new FunctionInfo(
        'currentWeatherForLocation',
        $weatherService,
        'returns the current weather in the given location. The result contains the description of the weather plus the current temperature in Celsius',
        [$location]
    );

    $chat->addFunction($function);
    $chat->setSystemMessage('You are an AI that answers to questions about weather in certain locations by calling external services to get the information');
    $this->result = $chat->generateText($this->prompt);
};

?>

<x:slide>
Service class that gets weather info from 3rd-party API
```php
class WeatherService {
    public function currentWeatherForLocation($location) {
        $wt = new Weather();
        $info = $wt->getCurrentByCity($location);
        return json_encode($info);
    }
}
```
Create and add function to our chat object.
```php
$weatherService = new WeatherService();
$function = new FunctionInfo(
    'currentWeatherForLocation',
    $weatherService,
    'Returns the current weather in the given location.
    The result contains the description of the weather plus
    the current temperature in Celsius',
    [$location]
);
$chat->addFunction($function);
```
Adds system message and requests response
```php
$chat->setSystemMessage('You are an AI that answers to questions
    about weather in certain locations by calling external services
    to get the information');

$result = $chat->generateText($this->prompt);
```
<x-slot name="code">
    <div class="flex gap-2 items-start mb-8">
        <input wire:model="prompt" type="text"
            class="flex-1 px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="getReply"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    @if($result)
        <div class="rounded-lg bg-gray-50 p-4 shadow-sm text-gray-700">
            {!! nl2br(e($result)) !!}
        </div>
    @endif
</x-slot>
</x:slide>
