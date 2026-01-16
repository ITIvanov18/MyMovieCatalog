/**
 * Handles advanced client-side interactions, real-time validation,
 * search filtering, and UI state management.
 */
class MovieManager {
    
    constructor() {
        // конфигурационни настройки
        this.config = {
            searchSelector: '#movie-search',
            statsSelector: '#search-stats',
            cardSelector: '.movie-card',
            titleSelector: '.movie-title',
            descriptionInput: '#description',
            counterDisplay: '#char-counter',
            maxDescriptionLength: 500,
            highlightColor: '#4f46e5', // Indigo-600
            errorColor: '#ef4444',     // Red-500
            defaultColor: '#6b7280'    // Gray-500
        };

        // инициализиране на приложението
        this.init();
    }

    /**
     * основен ентрипойнт за класа
     * използва try-catch блокове, за да гарантира, че грешка в един модул няма да срине приложението
     */
    init() {
        console.log('MovieManager: Booting up system...');

        try { 
            this.setupSearchListener(); 
            this.restoreSearchState(); // <-- НОВО: Възстановява старо търсене
        } catch (e) { 
            console.warn('Search Module Status: Inactive', e); 
        }

        try { 
            this.setupFormValidation(); 
        } catch (e) { 
            console.warn('Validation Module Status: Inactive (Not on edit page)', e); 
        }

        try {
            this.setupHoverEffects();
        } catch (e) {
            console.warn('UI Effects Status: Skipped');
        }

        console.log('MovieManager: System Ready.');
    }

    /**
     * задава слушател на събития за полето за търсене с дебаунсинг
     * това подобрява производителността при бързо писане
     */
    setupSearchListener() {
        const searchInput = document.querySelector(this.config.searchSelector);
        
        // Safety check: изход, ако елементът не съществува
        if (!searchInput) return;

        console.log('MovieManager: Search module loaded.');

        // дебаунсинг променлива
        let timeout = null;

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            // изчиства на предишния таймаут
            clearTimeout(timeout);

            // изчаква 300ms преди изпълнение на търсенето
            timeout = setTimeout(() => {
                this.filterMovies(query);
                this.saveSearchState(query);
            }, 300);
        });
    }

    /**
     * запазва търсенето на потребителя в LocalStorage
     * @param {string} query 
     */
    saveSearchState(query) {
        if (query.length > 0) {
            localStorage.setItem('last_movie_search', query);
        } else {
            localStorage.removeItem('last_movie_search');
        }
    }

    /**
     * възстановява последното търсене, ако е налично
     */
    restoreSearchState() {
        const searchInput = document.querySelector(this.config.searchSelector);
        if (!searchInput) return;

        const lastSearch = localStorage.getItem('last_movie_search');
        if (lastSearch) {
            searchInput.value = lastSearch;
            this.filterMovies(lastSearch);
            console.log('MovieManager: Restored last session search.');
        }
    }

    /**
     * основна логика за филтриране
     * обхожда DOM елементи и превключва видимостта
     * @param {string} query 
     */
    filterMovies(query) {
        const cards = document.querySelectorAll(this.config.cardSelector);
        let foundCount = 0;

        // визуална обратна връзка при празно търсене
        cards.forEach(card => {
            const titleElement = card.querySelector(this.config.titleSelector);
            const titleText = titleElement ? titleElement.textContent.toLowerCase() : '';
            
            if (titleText.includes(query)) {
                card.style.display = ''; 
                // fade in ефект
                setTimeout(() => { card.style.opacity = '1'; }, 50);
                foundCount++;
            } else {
                card.style.opacity = '0';
                // изчаква fade out преди скриване
                setTimeout(() => { card.style.display = 'none'; }, 300);
            }
        });

        this.updateSearchResultsCount(foundCount);
    }

    /**
     * обновява статистиката за резултатите от търсенето
     * @param {number} count 
     */
    updateSearchResultsCount(count) {
        const resultContainer = document.querySelector(this.config.statsSelector);
        if (!resultContainer) return;

        resultContainer.textContent = `Found ${count} movies matching your criteria.`;
        
        if (count === 0) {
            resultContainer.style.color = this.config.errorColor;
            resultContainer.classList.add('animate-pulse');
        } else {
            resultContainer.style.color = this.config.defaultColor;
            resultContainer.classList.remove('animate-pulse');
        }
    }

    /**
     * валидира формата в реално време
     * обработва броя на символите и визуалните състояния на валидиране
     */
    setupFormValidation() {
        const descInput = document.querySelector(this.config.descriptionInput);
        const counter = document.querySelector(this.config.counterDisplay);

        // safety check
        if (!descInput || !counter) return;

        console.log('MovieManager: Validation active.');

        const updateCounter = () => {
            const currentLength = descInput.value.length;
            const remaining = this.config.maxDescriptionLength - currentLength;
            
            counter.textContent = `${remaining} characters remaining`;

            // динамично стилизиране базирано на оставащите символи
            if (remaining < 0) {
                counter.textContent = `Limit exceeded by ${Math.abs(remaining)} chars!`;
                counter.style.color = this.config.errorColor;
                descInput.style.borderColor = this.config.errorColor;
            } else if (remaining < 50) {
                counter.style.color = '#d97706';
                counter.style.fontWeight = 'bold';
                descInput.style.borderColor = '#d97706';
            } else {
                counter.style.color = this.config.defaultColor;
                counter.style.fontWeight = 'normal';
                descInput.style.borderColor = '#e5e7eb';
            }
        };

        descInput.addEventListener('input', updateCounter);
        // първоначално извикване за настройка (за edit формата)
        updateCounter();
    }

    /**
     * добавя hover ефекти към филмовите карти
     * въпреки че CSS може да го направи, JS позволява по-сложна логика
     */
    setupHoverEffects() {
        const cards = document.querySelectorAll(this.config.cardSelector);
        
        if (cards.length === 0) return;

        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    }
}

// инициализиране на MovieManager при зареждане на DOM
document.addEventListener('DOMContentLoaded', () => {
    window.movieManager = new MovieManager();
});