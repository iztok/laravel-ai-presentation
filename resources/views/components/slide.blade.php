<div class="slide-view w-full h-[100dvh] flex justify-center items-center">
    <div class="slide-content [ h-5/6 w-4/5 ]">
        <x-markdown class="typography">
            {{ $slot }}
        </x-markdown>
        @if (!empty($code))
            <div class="py-8">
                {{ $code }}
            </div>
        @endif
    </div>
    <livewire:slides-navigation />
</div>
