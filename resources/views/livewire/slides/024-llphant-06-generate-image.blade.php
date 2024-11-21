<?php

use function Livewire\Volt\{state};
use LLPhant\Image\OpenAIImage;

state([
    'image_url' => null,
    'prompt' => 'Funny cat.',
    'revisedPrompt' => null,
    'reply' => '',
]);

$getReply = function () {
    if ($this->image_url == null) {
        $image = new OpenAIImage();
        $image->setModelOption('size', '1024x1024');
        $response = $image->generateImage($this->prompt);

        // Save image to local storage using Laravel Storage facade
        if ($response->url) {
            $filename = 'images/generated_' . time() . '.png';
            Storage::disk('public')->put(
                $filename,
                file_get_contents($response->url)
            );
            $this->image_url = Storage::disk('public')->url($filename);
            $this->revisedPrompt = $response->revisedPrompt;
        }
    }
};

?>

<x:slide>
## Generating images from prompt using OpenAI DALL-E
```php
$image = new OpenAIImage();
$response = $image->generateImage($prompt);
$image_url = $response->url; // Remote image URL
```
<x-slot name="code">
    <div class="flex gap-2 items-start mb-8">
        <input wire:model="prompt" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="getReply"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    @if ($image_url)
        <div class="mb-4">
            <div class="mb-4">
                <img src="{{ $image_url }}" />
            </div>
            <div class="rounded-lg bg-gray-50 p-4 shadow-sm text-gray-600 leading-relaxed">{!! nl2br(e($revisedPrompt)) !!}</div>
        </div>
    @endif
</x-slot>
</x:slide>
