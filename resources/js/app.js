import './bootstrap';

import Alpine from 'alpinejs';
import './movie-manager';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    
    // намира съобщението за успех (ако има такова)
    // търси елемента, който има специфичните Tailwind класове за зелен фон
    const successMessage = document.querySelector('.bg-green-100');

    if (successMessage) {
        // задава се таймер за 4 секунди
        setTimeout(() => {
            successMessage.style.transition = "opacity 0.5s ease";
            successMessage.style.opacity = "0";

            // след като избледнее напълно (0.5 сек), се маха от HTML-а
            setTimeout(() => {
                successMessage.remove();
            }, 500);
            
        }, 3000);
    }
});