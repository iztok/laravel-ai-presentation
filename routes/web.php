<?php

use Livewire\Volt\Volt;
use LLPhant\Chat\OpenAIChat;
use Illuminate\Support\Facades\Route;
use LLPhant\Query\SemanticSearch\QuestionAnswering;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;




$files = collect(glob(resource_path('views/livewire/slides/*.blade.php')))
    ->sort()
    ->values()
    ->each(function ($file, $index) {
        $path = '/' . ($index + 1);
        $name = 'slides/' . basename($file, '.blade.php');
        Volt::route($path, $name);
    });

Route::redirect('/', '/1');

