<?php

use function Livewire\Volt\{state, mount};
use LLPhant\Chat\Message;
use LLPhant\Chat\OpenAIChat;

state([
    'prompt' => 'Write a haiku about Laravel.',
    'reply' => '',
    'history' => null,
]);

$getReply = function () {
    $promt = $this->prompt;
    $this->prompt = '';

    $messages = collect(session('chat_history', []))
        ->map(function ($message) {
            return match($message['role']) {
                'user' => Message::user($message['content']),
                'assistant' => Message::assistant($message['content']),
            };
        })
        ->flatten()
        ->push(Message::user($promt))
        ->all();

    $chat = new OpenAIChat();
    $reply = $chat->generateChat($messages);

    session()->push('chat_history', [
        'role' => 'user',
        'content' => $promt
    ]);
    session()->push('chat_history', [
        'role' => 'assistant',
        'content' => $reply
    ]);

    $this->reply = $reply;
};

$clearSession = function () {
    session()->forget('chat_history');
    $this->reply = '';
};

?>

<x:slide>
Get history from session into array of Messages
```php
$messages = collect(session('chat_history', []))
    ->map(function ($message) {
        return match($message['role']) {
            'user' => Message::user($message['content']),
            'assistant' => Message::assistant($message['content']),
        };
    })
    ->flatten()
    ->push(Message::user($promt))
    ->all();
```
Generate reply from prompt + history
```php
$chat = new OpenAIChat();
$reply = $chat->generateChat($messages);
```
Add both, prompt and reply, to history
```php
session()->push('chat_history', [
    'role' => 'user',
    'content' => $promt
]);
session()->push('chat_history', [
    'role' => 'assistant',
    'content' => $reply
]);
```
<x-slot name="code">
    <div class="flex gap-2 items-start mb-8">
        <input wire:model="prompt" type="text"
            class="flex-1 px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="getReply"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
        <button wire:click="clearSession"
            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Clear
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    <div class="text-gray-700 space-y-6">
        @foreach (array_reverse(session('chat_history', [])) as $message)
            <div class="rounded-lg bg-gray-50 p-4 shadow-sm">
                <div class="font-semibold capitalize text-gray-900 mb-2">
                    {{ $message['role'] }}
                </div>
                <div class="text-gray-600 leading-relaxed">
                    {!! nl2br(e($message['content'])) !!}
                </div>
            </div>
        @endforeach
    </div>
</x-slot>
</x:slide>
