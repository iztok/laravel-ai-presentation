<?php

use function Livewire\Volt\{state, on};

state([
    'currentSlide' => fn() => (int) str_replace('/', '', request()->path()),
    'totalSlides' => fn() => collect(glob(resource_path('views/livewire/slides/*.blade.php')))->count(),
])->locked();

// $currentSlide => fn() => (int) str_replace('/', '', request()->path()),
// $totalSlides => fn() => collect(glob(resource_path('views/livewire/slides/*.blade.php')))->count(),

$hasPreviousSlide = fn() => $this->currentSlide > 1;
$hasNextSlide = fn() => $this->currentSlide < $this->totalSlides;

state([
    'hasPreviousSlide' => $hasPreviousSlide,
    'hasNextSlide' => $hasNextSlide,
])->locked();

$goToPreviousSlide = function(): void {
    if ($this->hasPreviousSlide()) {
        $this->redirect('/' . ($this->currentSlide - 1), navigate: true);
    }
};

$goToNextSlide = function(): void {
    if ($this->hasNextSlide()) {
        $this->redirect('/' . ($this->currentSlide + 1), navigate: true);
    }
};

on(['prevSlide' => function () {
    if ($this->hasPreviousSlide()) {
        $this->redirect('/' . ($this->currentSlide - 1), navigate: true);
    }
}]);

on(['nextSlide' => function () {
    if ($this->hasNextSlide()) {
        $this->redirect('/' . ($this->currentSlide + 1), navigate: true);
    }
}]);

?>

<section wire:keydown.left="goToPreviousSlide" wire:keydown.right.enter.space="goToNextSlide">
    @if($hasPreviousSlide)
    <button id="previous" type="button" title="Go back 1 slide" wire:click="goToPreviousSlide"
        class="browsershot-hide slide-arrow-button left-6 border-r-[30px] border-r-gray-300/50 hover:border-r-gray-300"></button>
    @endif
    @if($hasNextSlide)
    <button id="next" type="button" title="Go forward 1 slide" wire:click="goToNextSlide"
        class="browsershot-hide slide-arrow-button right-6 border-l-[30px] border-l-gray-300/50 hover:border-l-gray-300"></button>
    @endif
</section>

@script
<script>
    document.addEventListener('livewire:initialized', function () {
        window.addEventListener("keydown", function(event) {
            if (event.code === "ArrowLeft") {
                event.preventDefault();
                Livewire.dispatch('prevSlide');
            }
            if (event.code === "ArrowRight") {
                event.preventDefault();
                Livewire.dispatch('nextSlide');
            }
        });
    });
</script>
@endscript
