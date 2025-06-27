/**
 * FREELANCER SEARCH FUNCTIONALITY
 * Modern JavaScript implementation with AJAX, real-time search, and enhanced UX
 */

class FreelancerSearch {
    constructor() {
        this.searchForm = null;
        this.searchInput = null;
        this.searchButton = null;
        this.resultsContainer = null;
        this.loadingIndicator = null;
        this.debounceTimer = null;
        this.debounceDelay = 500; // ms
        this.currentQuery = '';
        this.isSearching = false;
        
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupSearch());
        } else {
            this.setupSearch();
        }
    }

    setupSearch() {
        this.findElements();
        if (this.searchForm && this.searchInput) {
            this.createResultsContainer();
            this.createLoadingIndicator();
            this.bindEvents();
            this.enhanceUI();
        }
    }

    findElements() {
        this.searchForm = document.querySelector('.search-form, form[action*="searchFreelancer"]');
        this.searchInput = document.querySelector('#search, input[name="search"]');
        this.searchButton = this.searchForm?.querySelector('input[type="submit"], button[type="submit"]');
    }

    createResultsContainer() {
        // Create results container if it doesn't exist
        this.resultsContainer = document.querySelector('#search-results');
        if (!this.resultsContainer) {
            this.resultsContainer = document.createElement('div');
            this.resultsContainer.id = 'search-results';
            this.resultsContainer.className = 'search-results-container';
            this.resultsContainer.innerHTML = '<div class="search-results-content"></div>';
            
            // Insert after the search form
            this.searchForm.parentNode.insertBefore(this.resultsContainer, this.searchForm.nextSibling);
        }
    }

    createLoadingIndicator() {
        this.loadingIndicator = document.createElement('div');
        this.loadingIndicator.className = 'search-loading';
        this.loadingIndicator.innerHTML = `
            <div class="loading-spinner"></div>
            <span>Searching freelancers...</span>
        `;
        this.loadingIndicator.style.display = 'none';
        this.resultsContainer.appendChild(this.loadingIndicator);
    }

    enhanceUI() {
        // Add enhanced styling classes
        this.searchInput.classList.add('search-enhanced');
        this.searchForm.classList.add('search-enhanced');
        
        // Add search icon to input
        const searchIcon = document.createElement('div');
        searchIcon.className = 'search-icon';
        searchIcon.innerHTML = '🔍';
        this.searchInput.parentNode.style.position = 'relative';
        this.searchInput.parentNode.appendChild(searchIcon);
        
        // Add clear button
        this.createClearButton();
        
        // Add live search toggle
        this.createLiveSearchToggle();
    }

    createClearButton() {
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'search-clear-btn';
        clearButton.innerHTML = '✕';
        clearButton.title = 'Clear search';
        clearButton.style.display = 'none';
        
        clearButton.addEventListener('click', () => this.clearSearch());
        this.searchInput.parentNode.appendChild(clearButton);
        this.clearButton = clearButton;
    }

    createLiveSearchToggle() {
        const toggleContainer = document.createElement('div');
        toggleContainer.className = 'live-search-toggle';
        toggleContainer.innerHTML = `
            <label>
                <input type="checkbox" id="live-search-toggle" checked>
                <span>Live search</span>
            </label>
        `;
        
        this.searchForm.appendChild(toggleContainer);
        this.liveSearchToggle = toggleContainer.querySelector('input[type="checkbox"]');
    }

    bindEvents() {
        // Prevent default form submission for AJAX handling
        this.searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.performSearch(this.searchInput.value.trim());
        });

        // Real-time search on input
        this.searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            this.updateClearButton(query);
            
            if (this.liveSearchToggle.checked) {
                this.debouncedSearch(query);
            }
        });

        // Search on focus if there's already a value
        this.searchInput.addEventListener('focus', (e) => {
            const query = e.target.value.trim();
            if (query && this.liveSearchToggle.checked) {
                this.performSearch(query);
            }
        });

        // Hide results when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.searchForm.contains(e.target) && !this.resultsContainer.contains(e.target)) {
                this.hideResults();
            }
        });

        // Keyboard navigation
        this.searchInput.addEventListener('keydown', (e) => this.handleKeyNavigation(e));
    }

    updateClearButton(query) {
        if (this.clearButton) {
            this.clearButton.style.display = query ? 'block' : 'none';
        }
    }

    debouncedSearch(query) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            if (query !== this.currentQuery) {
                this.performSearch(query);
            }
        }, this.debounceDelay);
    }

    async performSearch(query) {
        if (this.isSearching) {
            return; // Prevent multiple simultaneous requests
        }

        this.currentQuery = query;

        if (!query) {
            this.hideResults();
            return;
        }

        this.showLoading();
        this.isSearching = true;

        try {
            const results = await this.fetchSearchResults(query);
            this.displayResults(results, query);
        } catch (error) {
            this.displayError(error.message);
        } finally {
            this.hideLoading();
            this.isSearching = false;
        }
    }

    async fetchSearchResults(query) {
        const response = await fetch('../controller/searchFreelancer.php?search=' + encodeURIComponent(query), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicate AJAX request
            }
        });

        if (!response.ok) {
            throw new Error(`Search failed: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.message || 'Search failed');
        }

        return data.results;
    }

    displayResults(results, query) {
        const contentDiv = this.resultsContainer.querySelector('.search-results-content');
        
        if (results.length === 0) {
            contentDiv.innerHTML = `
                <div class="no-results">
                    <div class="no-results-icon">🔍</div>
                    <p>No freelancers found for "<strong>${this.escapeHtml(query)}</strong>"</p>
                    <small>Try a different search term or user ID</small>
                </div>
            `;
        } else {
            const resultsHtml = results.map(freelancer => `
                <div class="search-result-item" data-user-id="${freelancer.user_id}">
                    <div class="result-header">
                        <h4>${this.highlightText(freelancer.username, query)}</h4>
                        <span class="user-id">ID: ${freelancer.user_id}</span>
                    </div>
                    <div class="result-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewFreelancerProfile('${freelancer.user_id}')">
                            View Profile
                        </button>
                        <button class="btn btn-secondary btn-sm" onclick="contactFreelancer('${freelancer.user_id}')">
                            Contact
                        </button>
                    </div>
                </div>
            `).join('');

            contentDiv.innerHTML = `
                <div class="search-results-header">
                    <h3>Found ${results.length} freelancer${results.length !== 1 ? 's' : ''}</h3>
                    <button class="btn-text" onclick="freelancerSearch.viewAllResults('${query}')">
                        View detailed results
                    </button>
                </div>
                <div class="search-results-list">
                    ${resultsHtml}
                </div>
            `;
        }

        this.showResults();
    }

    displayError(message) {
        const contentDiv = this.resultsContainer.querySelector('.search-results-content');
        contentDiv.innerHTML = `
            <div class="search-error">
                <div class="error-icon">⚠️</div>
                <p>Search Error</p>
                <small>${this.escapeHtml(message)}</small>
                <button class="btn btn-secondary btn-sm" onclick="freelancerSearch.retrySearch()">
                    Try Again
                </button>
            </div>
        `;
        this.showResults();
    }

    highlightText(text, query) {
        if (!query) return this.escapeHtml(text);
        
        const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');
        return this.escapeHtml(text).replace(regex, '<mark>$1</mark>');
    }

    showResults() {
        this.resultsContainer.style.display = 'block';
        this.resultsContainer.classList.add('show');
        // Animate in
        setTimeout(() => {
            this.resultsContainer.classList.add('animate-in');
        }, 10);
    }

    hideResults() {
        this.resultsContainer.classList.remove('animate-in');
        setTimeout(() => {
            this.resultsContainer.style.display = 'none';
            this.resultsContainer.classList.remove('show');
        }, 300);
    }

    showLoading() {
        this.loadingIndicator.style.display = 'flex';
        this.searchButton.disabled = true;
        this.searchInput.classList.add('searching');
    }

    hideLoading() {
        this.loadingIndicator.style.display = 'none';
        this.searchButton.disabled = false;
        this.searchInput.classList.remove('searching');
    }

    clearSearch() {
        this.searchInput.value = '';
        this.searchInput.focus();
        this.hideResults();
        this.currentQuery = '';
        this.updateClearButton('');
    }

    retrySearch() {
        const query = this.searchInput.value.trim();
        if (query) {
            this.performSearch(query);
        }
    }

    viewAllResults(query) {
        // Navigate to the full results page
        window.location.href = `../controller/searchFreelancer.php?search=${encodeURIComponent(query)}`;
    }

    handleKeyNavigation(e) {
        const results = this.resultsContainer.querySelectorAll('.search-result-item');
        const currentSelected = this.resultsContainer.querySelector('.search-result-item.selected');
        
        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.selectNextResult(results, currentSelected);
                break;
            case 'ArrowUp':
                e.preventDefault();
                this.selectPreviousResult(results, currentSelected);
                break;
            case 'Enter':
                if (currentSelected) {
                    e.preventDefault();
                    const userId = currentSelected.dataset.userId;
                    viewFreelancerProfile(userId);
                }
                break;
            case 'Escape':
                this.hideResults();
                break;
        }
    }

    selectNextResult(results, current) {
        if (results.length === 0) return;
        
        if (current) {
            current.classList.remove('selected');
            const next = current.nextElementSibling;
            if (next && next.classList.contains('search-result-item')) {
                next.classList.add('selected');
                next.scrollIntoView({ block: 'nearest' });
            } else {
                results[0].classList.add('selected');
            }
        } else {
            results[0].classList.add('selected');
        }
    }

    selectPreviousResult(results, current) {
        if (results.length === 0) return;
        
        if (current) {
            current.classList.remove('selected');
            const prev = current.previousElementSibling;
            if (prev && prev.classList.contains('search-result-item')) {
                prev.classList.add('selected');
                prev.scrollIntoView({ block: 'nearest' });
            } else {
                results[results.length - 1].classList.add('selected');
            }
        } else {
            results[results.length - 1].classList.add('selected');
        }
    }

    // Utility functions
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
}

// Global functions for button actions
window.viewFreelancerProfile = function(userId) {
    // Navigate to freelancer profile page
    window.location.href = `viewUser.php?user_id=${userId}`;
};

window.contactFreelancer = function(userId) {
    // Navigate to messaging system or open contact modal
    window.location.href = `message.php?user_id=${userId}`;
};

// Initialize the search functionality
let freelancerSearch;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        freelancerSearch = new FreelancerSearch();
    });
} else {
    freelancerSearch = new FreelancerSearch();
}
