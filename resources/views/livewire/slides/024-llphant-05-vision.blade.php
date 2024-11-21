<?php

use function Livewire\Volt\{state};
use LLPhant\OpenAIConfig;
use LLPhant\Chat\OpenAIChat;
use LLPhant\Chat\Vision\ImageSource;
use LLPhant\Chat\Vision\VisionMessage;

state([
    'image_url' => 'https://a.storyblok.com/f/229922/1430x840/1ae55ea914/screenshot-2024-10-21-at-11-34-55.png?cv=1729504010203',
    'prompt' => 'Describe what is in the photo.',
    'reply' => '',
]);

$getReply = function () {
    $prompt = $this->prompt;
    $image_url = $this->image_url;

    $config = new OpenAIConfig();
    $config->model = 'gpt-4o'; // Multimodal
    $chat = new OpenAIChat($config);

    $messages = [
        VisionMessage::fromImages([
            new ImageSource($image_url),
        ], $prompt)
    ];

    $response = $chat->generateChat($messages);

    $this->reply = $response;
};

?>

<x:slide>
## Vision
Latest GPT models can also read images. LLPhant supports that out of the box, we only have to use the right model:
```php{2}
$config = new OpenAIConfig();
$config->model = 'gpt-4o'; // multimodal model
$chat = new OpenAIChat($config);
```
List of messages can now include a special type "VisionMessage" with images attached:
```php
$messages = [
    VisionMessage::fromImages([
        new ImageSource($this->image_url),
    ], $this->prompt)
];
```
We request for response as before:
```php
$response = $chat->generateChat($messages);
```
<x-slot name="code">
    <div class="w-1/2 mb-4">
        <img src="{{ $image_url }}" />
    </div>
    <div class="flex gap-2 items-start mb-8">
        <input wire:model.live.debounce.150ms="image_url" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <input wire:model="prompt" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="getReply"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    @if($reply)
        <div class="rounded-lg bg-gray-50 p-4 shadow-sm text-gray-600 leading-relaxed">{!! nl2br(e($reply)) !!}</div>
    @endif
</x-slot>
</x:slide>
