<?php

use Livewire\Volt\Volt;
use RakibDevs\Weather\Weather;
use LLPhant\Chat\AnthropicChat;
use Illuminate\Support\Facades\Route;
use LLPhant\Chat\FunctionInfo\Parameter;
use LLPhant\Chat\FunctionInfo\FunctionInfo;

$files = collect(glob(resource_path('views/livewire/slides/*.blade.php')))
    ->sort()
    ->values()
    ->each(function ($file, $index) {
        $path = '/' . ($index + 1);
        $name = 'slides/' . basename($file, '.blade.php');
        Volt::route($path, $name);
    });

Route::redirect('/', '/1');
