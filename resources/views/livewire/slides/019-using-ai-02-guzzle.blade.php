<?php

use function Livewire\Volt\{state};

function runCode($arg)
{
    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ],
            'json' => [
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $arg,
                    ],
                ],
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['choices'][0]['message']['content'];
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

state([
    'query' => 'Write a haiku about Laravel.',
    'result' => '',
]);

$runCode = fn () => $this->result = runCode($this->query);

?>

<x:slide>
### Laravel way
```php
$client = new \GuzzleHttp\Client();
$response = $client->post('https://api.openai.com/v1/chat/completions', [
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    ],
    'json' => [
        'model' => 'gpt-4o',
        'messages' => [
            [
                'role' => 'user',
                'content' => $arg,
            ],
        ],
    ],
]);
$result = json_decode($response->getBody(), true);
return $result['choices'][0]['message']['content'];
```
<x-slot name="code">
    <div class="flex gap-2 items-start pt-4">
        <input wire:model="query" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="runCode" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
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
