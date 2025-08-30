
<style>
    /* Elegant notification styles */
    .notification {
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
    }

    /* Glass morphism effect */
    .notification-success {
        background: rgba(240, 253, 244, 0.95);
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .notification-error {
        background: rgba(254, 242, 242, 0.95);
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }

    .notification-warning {
        background: rgba(255, 251, 235, 0.95);
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    .notification-info {
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
        animation: progressBar linear forwards;
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

    .notification-enter {
        animation: slideIn 0.3s ease-out forwards;
    }

    .notification-exit {
        animation: slideOut 0.3s ease-in forwards;
    }

    /* Icon styles */
    .notification-icon {
        margin-right: 0.75rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .notification-icon svg {
        width: 1.25rem;
        height: 1.25rem;
    }
</style>

<div class="fixed top-4 right-4 z-[9999] space-y-3 w-80 max-w-[90vw]" id="notification-container">
    <!-- Notifications will be dynamically inserted here -->
</div>

@push('scripts')
<script>
    class NotificationManager {
        constructor() {
            this.container = document.getElementById('notification-container');
            if (!this.container) {
                this.createContainer();
            }
            this.notificationCount = 0;
        }

        createContainer() {
            this.container = document.createElement('div');
            this.container.id = 'notification-container';
            this.container.className = 'fixed top-4 right-4 z-[9999] space-y-3 w-80 max-w-[90vw]';
            document.body.appendChild(this.container);
        }

        getIcon(type) {
            const icons = {
                success: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>`,
                error: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>`,
                warning: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>`,
                info: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>`
            };
            return icons[type] || icons.info;
        }

        show(message, type = 'success', duration = 5000) {
            const notificationId = `notification-${++this.notificationCount}`;
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `notification notification-${type} notification-enter`;
            
            notification.innerHTML = `
                <div class="notification-icon">${this.getIcon(type)}</div>
                <div class="notification-content">
                    <div class="notification-title">${this.getTitle(type)}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close" onclick="notifications.remove('${notificationId}')">
                    &times;
                </button>
                <div class="notification-progress" style="animation-duration: ${duration}ms"></div>
            `;

            this.container.appendChild(notification);

            // Auto remove after duration
            if (duration > 0) {
                setTimeout(() => {
                    this.remove(notificationId);
                }, duration);
            }

            return notificationId;
        }

        getTitle(type) {
            const titles = {
                success: 'Success',
                error: 'Error',
                warning: 'Warning',
                info: 'Information'
            };
            return titles[type] || 'Notification';
        }

        remove(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.remove('notification-enter');
                notification.classList.add('notification-exit');
                
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300); // Match animation duration
            }
        }

        success(message, duration = 5000) {
            return this.show(message, 'success', duration);
        }

        error(message, duration = 5000) {
            return this.show(message, 'error', duration);
        }

        warning(message, duration = 5000) {
            return this.show(message, 'warning', duration);
        }

        info(message, duration = 5000) {
            return this.show(message, 'info', duration);
        }
    }

    // Initialize notification manager
    const notifications = new NotificationManager();

    // Make it globally available
    window.notifications = notifications;
</script>
@endpush