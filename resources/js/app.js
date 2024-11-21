import './bootstrap';
import textFit from 'textfit';

document.addEventListener('livewire:init', () => {
    Livewire.hook('element.init', ({ component, el }) => {
        const elements = document.querySelectorAll('.slide-content');
        elements.forEach(element => {
            textFit(element, {
                multiLine: true,
                maxFontSize: 100,
                minFontSize: 28,
                reProcess: true
            });
        });
    })
})
