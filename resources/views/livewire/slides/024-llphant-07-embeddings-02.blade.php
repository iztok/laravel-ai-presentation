<?php

use function Livewire\Volt\{state};
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

state([
    'text' => 'Cat',
    'embedding' => null
]);

$getEmbedding = function () {
    $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
    $this->embedding = $embeddingGenerator->embedText($this->text);
};

?>

<x:slide>
LLPhant offers generation of embeddings with models from OpenAI, Mistral or local Ollama out of the box.

```php
$embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
$embedding = $embeddingGenerator->embedText($text);
```
<x-slot name="code">
    <div class="flex gap-2 items-start pt-4 mb-4">
        <input wire:model="text" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="getEmbedding"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Send
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    @if ($embedding)
    <div class="text-gray-700 max-w-full text-sm">
        <div>
            {{ wordwrap(json_encode($embedding), 1, "\n", true) }}
        </div>
    </div>
    @endif
</x-slot>
</x:slide>
