<?php

use function Livewire\Volt\{state};
use LLPhant\Embeddings\DataReader\FileDataReader;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;


state([
    'question' => 'Camera is not working',
    'documents' => null,
]);

$search = function () {
    $vectorStore = new FileSystemVectorStore(storage_path('app/private/vector_store.json'));
    $searchEmbedding = (new OpenAI3SmallEmbeddingGenerator())->embedText($this->question);
    $results = $vectorStore->similaritySearch($searchEmbedding, 4);
    $this->documents = array_map(fn($doc) => $doc->content, $results);
};

?>

<x:slide>
When user asks a question, we convert it to a vector to be compared with chunks in our database.
```php
$searchEmbedding = $embeddingGen->embedText($question);
$results = $vectorStore->similaritySearch($searchEmbedding, 4);
```
<x-slot name="code">
    <div class="flex gap-2 items-start pt-4 mb-4">
        <input wire:model="question" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="search"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Ask
        </button>
        <span wire:loading>
            Loading
        </span>
    </div>

    @if ($documents)
        <div class="text-gray-700">
            @foreach ($documents as $document)
                <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow text-sm">
                    {{ $document }}
                </div>
            @endforeach
        </div>
    @endif
</x-slot>
</x:slide>
