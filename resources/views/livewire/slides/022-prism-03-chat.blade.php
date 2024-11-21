<?php

use function Livewire\Volt\{state};
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Enums\Provider;
use EchoLabs\Prism\ValueObjects\Messages\UserMessage;

function runCode($prompt)
{
    $response = Prism::text()
        ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
        ->withSystemPrompt('You speak pirate language only.')
        ->withPrompt($prompt)
        ->generate();

    return $response->text;
}

state([
    'query' => 'Write a haiku about Laravel.',
    'result' => '',
]);

$runCode = fn() => ($this->result = runCode($this->query));

?>

<x:slide>
Prism gives us the familiar function chaining with pipes and useful helper methods.
```
$response = Prism::text()
    ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
    ->withSystemPrompt('You speak pirate language only.')
    ->withPrompt($prompt)
    ->generate();
return $response->text;
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
