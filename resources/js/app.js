import './bootstrap';

// ULTRA-AGGRESSIVE: Inject styles IMMEDIATELY into head to prevent any flash
(function() {
    // Create and inject critical styles BEFORE anything else renders
    const criticalCSS = document.createElement('style');
    criticalCSS.innerHTML = `
        /* CRITICAL: Prevent any rendering flash */
        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        html, body {
            background: linear-gradient(135deg, rgba(240, 253, 244, 0.98) 0%, rgba(241, 253, 246, 0.98) 100%) !important;
            margin: 0;
            padding: 0;
        }

        /* CRITICAL: Hide floating chatbot from the start */
        #floatingChatbot {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            will-change: opacity, visibility;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            contain: layout style paint;
            position: fixed;
            z-index: 40;
            transition: opacity 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Show floating chatbot when ready */
        #floatingChatbot.visible {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }

        /* CRITICAL: Hide floating chat window */
        #floatingChatWindow {
            display: none !important;
            visibility: hidden !important;
            will-change: auto;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        /* Prevent jank on floating chat elements */
        #floatingChatbot,
        #floatingChatWindow {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }
        
        /* Smooth transition overlay */
        #page-transition-overlay {
            will-change: opacity;
            transform: translateZ(0);
        }

        /* Optimize main content transitions */
        main {
            will-change: opacity;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        @media (prefers-reduced-motion: no-preference) {
            #page-transition-overlay {
                animation: overlayFadeIn 0.2s cubic-bezier(0.4, 0, 0.6, 1) forwards;
            }
            
            @keyframes overlayFadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
        }
    `;
    
    // Insert at the very beginning of head
    if (document.head) {
        document.head.insertBefore(criticalCSS, document.head.firstChild);
    } else {
        // Fallback if head not ready yet
        document.addEventListener('DOMContentLoaded', () => {
            document.head.insertBefore(criticalCSS, document.head.firstChild);
        });
    }
})();

// Page transition overlay for smooth navigation
class PageTransitionManager {
    constructor() {
        this.overlay = null;
        this.isTransitioning = false;
        this.hideTimeout = null;
        this.init();
    }

    init() {
        // Attach navigation listeners only
        this.attachNavigationListeners();

        // Preload floating chat element
        this.preloadFloatingChat();

        // Reset transition flag when page loads
        window.addEventListener('load', () => {
            this.isTransitioning = false;
        }, false);

        document.addEventListener('DOMContentLoaded', () => {
            if (this.hideTimeout) {
                clearTimeout(this.hideTimeout);
                this.hideTimeout = null;
            }
            this.isTransitioning = false;
        });
    }

    preloadFloatingChat() {
        const floatingChat = document.getElementById('floatingChatbot');
        if (floatingChat) {
            floatingChat.style.willChange = 'opacity, visibility';
            // Wait until DOMContentLoaded to show floating chat with smooth transition
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    // Use requestAnimationFrame for perfectly timed transition
                    requestAnimationFrame(() => {
                        floatingChat.classList.add('visible');
                    });
                }, { once: true });
            } else {
                requestAnimationFrame(() => {
                    floatingChat.classList.add('visible');
                });
            }
        }
    }

    attachNavigationListeners() {
        // Handle link clicks
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link) return;

            // Skip if link is external, has target="_blank", or is same page
            if (link.hasAttribute('target') || link.hostname !== window.location.hostname) {
                return;
            }

            // Skip if it's an anchor or javascript link
            if (link.href.startsWith('javascript:') || link.href.startsWith('#')) {
                return;
            }

            // Check if it's a form submit or special button
            if (link.hasAttribute('onclick') || link.closest('form')) {
                return;
            }

            // Prevent multiple clicks during transition
            if (this.isTransitioning) {
                e.preventDefault();
                return;
            }

            // Mark as transitioning
            this.isTransitioning = true;
            
            // Hide floating chat immediately for instant transition
            this.hideFloatingChat();
        });

        // Also handle form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            // Don't trigger for AJAX forms
            if (!form.hasAttribute('data-no-transition') && !this.isTransitioning) {
                this.isTransitioning = true;
                this.hideFloatingChat();
            }
        });

        // Cleanup floating chat on page unload
        window.addEventListener('beforeunload', () => {
            this.hideFloatingChat();
        });
    }

    hideFloatingChat() {
        const floatingChat = document.getElementById('floatingChatbot');
        if (floatingChat) {
            floatingChat.classList.remove('visible');
        }
    }


}

// Initialize page transition manager
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.pageTransitionManager = new PageTransitionManager();
    });
} else {
    window.pageTransitionManager = new PageTransitionManager();
}

// Password visibility toggle function
window.togglePassword = function(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById('eyeIcon_' + fieldId) || document.getElementById(fieldId + '-icon');

    if (field && icon) {
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
};
