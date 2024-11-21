<?php

use function Livewire\Volt\{state};

use LLPhant\Chat\OpenAIChat;
use LLPhant\Query\SemanticSearch\QuestionAnswering;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

state([
    'prompt' => 'My computer has blank screen',
    'reply' => null,
]);

$ask = function () {
    $vectorStore = new FileSystemVectorStore(storage_path('documents/vector_store.json'));
    $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
    $qa = new QuestionAnswering(
        $vectorStore,
        $embeddingGenerator,
        new OpenAIChat()
    );
    $this->reply = $qa->answerQuestion($this->prompt);
};

?>

<x:slide>
### Q&A

Raw search results from vector similarity can be hard for users to parse and understand.

Instead, we can feed the most relevant document chunks to an LLM to generate a natural, coherent answer to the user's question.

LLPhant makes this easy with its built-in QuestionAnswering class that handles the entire RAG workflow - from finding relevant context to generating the final response.

```php
$storageJsonFile = storage_path('vector_store.json');
$vectorStore = new FileSystemVectorStore($storageJsonFile);
$embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
$qa = new QuestionAnswering(
    $vectorStore,
    $embeddingGenerator,
    new OpenAIChat()
);
$answer = $qa->answerQuestion($question);
```
<x-slot name="code">
    <div class="flex gap-2 items-start pt-4 mb-4">
        <input wire:model="prompt" type="text"
            class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button wire:click="ask"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Ask
        </button>
    </div>
    <span wire:loading>
        Loading
    </span>
    @if ($reply)
        <div class="rounded-lg bg-gray-50 p-4 shadow-sm text-gray-900">
            {!! nl2br(e($reply)) !!}
        </div>
    @endif
</x-slot>
</x:slide>
