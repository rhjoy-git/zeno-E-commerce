<style>
    .session-notification {
        position: relative;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
            0 8px 10px -6px rgba(0, 0, 0, 0.05);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: flex-start;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform-origin: top right;
        animation: slideIn 0.3s ease-out forwards;
    }

    /* Glass morphism effect */
    .session-notification-success {
        background: rgba(240, 253, 244, 0.95);
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .session-notification-error {
        background: rgba(254, 242, 242, 0.95);
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }

    .session-notification-warning {
        background: rgba(255, 251, 235, 0.95);
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    .session-notification-info {
        background: rgba(239, 246, 255, 0.95);
        border-left: 4px solid #3b82f6;
        color: #1e40af;
    }

    .notification-content {
        flex: 1;
        padding-right: 1.5rem;
    }

    .notification-title {
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .notification-message {
        font-size: 0.875rem;
        opacity: 0.9;
        line-height: 1.4;
    }

    .notification-icon {
        margin-right: 0.75rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .notification-icon svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .notification-close {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: none;
        border: none;
        font-size: 1.125rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        transition: opacity 0.2s ease;
        padding: 0.25rem;
        border-radius: 0.25rem;
    }

    .notification-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.05);
    }

    /* Progress bar */
    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: currentColor;
        opacity: 0.3;
        width: 100%;
        transform-origin: left;
        animation: progressBar 5s linear forwards;
    }

    /* Animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%) scale(0.9);
            opacity: 0;
        }

        to {
            transform: translateX(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0) scale(1);
            opacity: 1;
        }

        to {
            transform: translateX(100%) scale(0.9);
            opacity: 0;
        }
    }

    @keyframes progressBar {
        from {
            transform: scaleX(1);
        }

        to {
            transform: scaleX(0);
        }
    }
</style>
<div class="fixed top-4 right-4 z-[9998] space-y-3 w-80 max-w-[90vw]" id="session-notification-container">
    @if (session('status'))
    <div class="session-notification session-notification-success">
        <div class="notification-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="notification-content">
            <div class="notification-title">Success</div>
            <div class="notification-message">{{ session('status') }}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            &times;
        </button>
        <div class="notification-progress"></div>
    </div>
    @endif

    @if (session('success'))
    <div class="session-notification session-notification-success">
        <div class="notification-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="notification-content">
            <div class="notification-title">Success</div>
            <div class="notification-message">{{ session('success') }}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            &times;
        </button>
        <div class="notification-progress"></div>
    </div>
    @endif

    @if (session('error'))
    <div class="session-notification session-notification-error">
        <div class="notification-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="notification-content">
            <div class="notification-title">Error</div>
            <div class="notification-message">{{ session('error') }}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            &times;
        </button>
        <div class="notification-progress"></div>
    </div>
    @endif

    @if (session('warning'))
    <div class="session-notification session-notification-warning">
        <div class="notification-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="notification-content">
            <div class="notification-title">Warning</div>
            <div class="notification-message">{{ session('warning') }}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            &times;
        </button>
        <div class="notification-progress"></div>
    </div>
    @endif

    @if (session('info'))
    <div class="session-notification session-notification-info">
        <div class="notification-icon">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="notification-content">
            <div class="notification-title">Information</div>
            <div class="notification-message">{{ session('info') }}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            &times;
        </button>
        <div class="notification-progress"></div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Enhanced session notification handling
        const sessionNotifications = document.querySelectorAll('.session-notification');
        
        sessionNotifications.forEach(notification => {
            // Add close functionality
            const closeBtn = notification.querySelector('.notification-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    animateRemoveNotification(notification);
                });
            }
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                animateRemoveNotification(notification);
            }, 5000);
            
            // Pause progress bar on hover
            const progressBar = notification.querySelector('.notification-progress');
            notification.addEventListener('mouseenter', () => {
                if (progressBar) {
                    progressBar.style.animationPlayState = 'paused';
                }
            });
            
            notification.addEventListener('mouseleave', () => {
                if (progressBar) {
                    progressBar.style.animationPlayState = 'running';
                }
            });
        });
        
        function animateRemoveNotification(notification) {
            if (!notification.parentElement) return;
            
            notification.style.animation = 'slideOut 0.3s ease-in forwards';
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }
        
        // Clear session flash data after displaying
        setTimeout(() => {
            fetch('{{ route("clear.session.notifications") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(error => console.error('Error clearing session notifications:', error));
        }, 5000);
    });
</script>
@endpush