<?php

use function Livewire\Volt\{state};
use OpenAI\Laravel\Facades\OpenAI;

function runCode($arg)
{
    $result = OpenAI::chat()->create([
        'model' => 'gpt-4o',
        'messages' => [['role' => 'user', 'content' => $arg]],
    ]);
    return $result->choices[0]->message->content;
}

state([
    'query' => 'Write a haiku about Laravel.',
    'result' => '',
]);

$runCode = fn() => ($this->result = runCode($this->query));

?>

<x:slide>
Installation:
```
composer require openai-php/laravel
```
.env
```
OPENAI_API_KEY=sk-...
```
PHP code:
```php
$result = OpenAI::chat()->create([
    'model' => 'gpt-4o',
    'messages' => [
        [
            'role' => 'user',
            'content' => $arg
        ]
    ],
]);
return $result->choices[0]->message->content;
```
<x-slot name="code">
    <div class="flex gap-2 items-start mb-4">
        <input wire:model="query" type="text"
            class="flex-1 px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="runCode"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
    </div>
    @if($result)
        <div class="rounded-lg bg-gray-50 p-4 shadow-sm text-gray-700">
            <span wire:loading>
                Loading
            </span>
            {!! nl2br(e($result)) !!}
        </div>
    @endif
</x-slot>
</x:slide>
