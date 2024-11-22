<?php

use function Livewire\Volt\{state};
use LLPhant\Embeddings\DataReader\FileDataReader;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;


state([
    'documents' => null,
]);

$storeEmbeddings = function () {
    if (file_exists(storage_path('app/private/vector_store.json'))) {
        unlink(storage_path('app/private/vector_store.json'));
    }

    $file = storage_path('documents/macbook_manual.pdf');
    $fileReader = new FileDataReader($file);

    $documents = $fileReader->getDocuments();
    $splitDocuments = DocumentSplitter::splitDocuments($documents, 2000);

    $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
    $embeddedDocuments = $embeddingGenerator->embedDocuments($splitDocuments);

    $storageJsonFile = storage_path('app/private/vector_store.json');
    $vectorStore = new FileSystemVectorStore($storageJsonFile);
    $vectorStore->addDocuments($embeddedDocuments);

    $this->documents = array_map(fn($doc) => $doc->content, $embeddedDocuments);
};

?>

<x:slide>
LLPhant offers integrations with multiple options and providers to store vectors and search in them.

Example of loading a PDF:
```php
$file = storage_path('documents/macbook_manual.pdf');
$fileReader = new FileDataReader($file);
$docs = $fileReader->getDocuments();
```
We can split the document into smaller chunks.
```php
$splitDocs = DocumentSplitter::splitDocuments($docs);
```
We create embedding for each chunk (this can be a lot of requests depending on your document size).
```php
$embeddingGen = new OpenAI3SmallEmbeddingGenerator();
$embeddedDocs = $embeddingGen->embedDocuments($splitDocs);
```
We save the documents with embedding into a vector storage. We use a dumb local vector storage in this example.
```php
$storageJsonFile = storage_path('vector_store.json');
$vectorStore = new FileSystemVectorStore($storageJsonFile);
$vectorStore->addDocuments($embeddedDocs);
```
<x-slot name="code">
    <div class="flex gap-2 items-start pt-4">
        <div class="flex-1">
            <button wire:click="storeEmbeddings"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Slice and store documents
            </button>
            <span wire:loading>
                Loading
            </span>
        </div>
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
