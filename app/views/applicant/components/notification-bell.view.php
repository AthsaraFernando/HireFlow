<?php
$notificationFeedUrl = ROOT . '/applicant/notifications/feed';
$notificationMarkReadUrl = ROOT . '/applicant/notifications/markRead';
$notificationDeleteUrl = ROOT . '/applicant/notifications/delete';
?>
<div class="applicant-header-actions">
    <div class="applicant-notification-widget"
         data-applicant-notifications
         data-feed-url="<?= htmlspecialchars($notificationFeedUrl, ENT_QUOTES) ?>"
         data-mark-read-url="<?= htmlspecialchars($notificationMarkReadUrl, ENT_QUOTES) ?>"
         data-delete-url="<?= htmlspecialchars($notificationDeleteUrl, ENT_QUOTES) ?>">
        <button type="button" class="applicant-notification-toggle" aria-label="Open notifications" aria-expanded="false">
            <span class="notification-bell-icon" aria-hidden="true">🔔</span>
            <span class="applicant-notification-badge" data-notification-badge hidden>0</span>
        </button>

        <div class="applicant-notification-panel" data-notification-panel hidden>
            <div class="applicant-notification-panel-header">
                <div>
                    <h4>Notifications</h4>
                    <p>Recent interview and feedback updates</p>
                </div>
                <a href="<?= ROOT ?>/applicant/notifications" class="applicant-notification-view-all">View all</a>
            </div>

            <div class="applicant-notification-list" data-notification-list>
                <div class="applicant-notification-empty">Loading notifications...</div>
            </div>
        </div>
    </div>

    <style>
        .applicant-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .applicant-notification-widget {
            position: relative;
        }

        .applicant-notification-toggle {
            position: relative;
            width: 44px;
            height: 44px;
            border: 1px solid rgba(148, 163, 184, 0.24);
            border-radius: 14px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #1f2937;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .applicant-notification-toggle:hover,
        .applicant-notification-toggle:focus-visible {
            transform: translateY(-1px);
            border-color: rgba(59, 130, 246, 0.35);
            box-shadow: 0 16px 28px rgba(15, 23, 42, 0.12);
            outline: none;
        }

        .notification-bell-icon {
            font-size: 1.05rem;
            line-height: 1;
        }

        .applicant-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 18px;
            text-align: center;
            border: 2px solid #fff;
        }

        .applicant-notification-panel {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            width: min(390px, calc(100vw - 32px));
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.96);
            border-radius: 20px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.18);
            overflow: hidden;
            z-index: 1200;
        }

        .applicant-notification-panel[hidden] {
            display: none !important;
        }

        .applicant-notification-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 18px 14px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
        }

        .applicant-notification-panel-header h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .applicant-notification-panel-header p {
            margin: 4px 0 0;
            color: rgba(226, 232, 240, 0.9);
            font-size: 0.8rem;
        }

        .applicant-notification-view-all {
            color: #dbeafe;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .applicant-notification-list {
            max-height: 420px;
            overflow-y: auto;
        }

        .applicant-notification-item {
            display: block;
            padding: 14px 18px;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.18s ease, transform 0.18s ease;
        }

        .applicant-notification-item:hover,
        .applicant-notification-item:focus-visible {
            background: #f8fafc;
            outline: none;
        }

        .applicant-notification-item:last-child {
            border-bottom: 0;
        }

        .applicant-notification-item.read {
            background: #f8fafc;
            opacity: 0.72;
        }

        .applicant-notification-item.read .applicant-notification-title {
            color: #475569;
            font-weight: 600;
        }

        .applicant-notification-item-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .applicant-notification-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 8px;
        }

        .applicant-notification-open {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 8px;
            text-decoration: none;
            background: #e2e8f0;
            color: #1e293b;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .applicant-notification-delete {
            width: 24px;
            height: 24px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            border-radius: 6px;
            font-size: 0.75rem;
            cursor: pointer;
            line-height: 1;
        }

        .applicant-notification-delete:hover {
            background: #fee2e2;
            border-color: #fecaca;
            color: #b91c1c;
        }

        .applicant-notification-title {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
        }

        .applicant-notification-type {
            display: inline-flex;
            align-items: center;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .applicant-notification-type.success { background: #dcfce7; color: #166534; }
        .applicant-notification-type.warning { background: #fef3c7; color: #92400e; }
        .applicant-notification-type.error { background: #fee2e2; color: #991b1b; }
        .applicant-notification-type.info { background: #dbeafe; color: #1d4ed8; }

        .applicant-notification-message {
            margin: 8px 0 0;
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .applicant-notification-meta {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
            color: #64748b;
            font-size: 0.78rem;
        }

        .applicant-notification-empty {
            padding: 22px 18px;
            text-align: center;
            color: #64748b;
            font-size: 0.92rem;
        }

        @media (max-width: 640px) {
            .applicant-notification-panel {
                right: -56px;
                width: min(340px, calc(100vw - 16px));
            }
        }
    </style>

    <script>
        (function () {
            const widget = document.querySelector('[data-applicant-notifications]');

            if (!widget || widget.dataset.notificationsInitialized === '1') {
                return;
            }

            widget.dataset.notificationsInitialized = '1';

            const toggle = widget.querySelector('.applicant-notification-toggle');
            const panel = widget.querySelector('[data-notification-panel]');
            const badge = widget.querySelector('[data-notification-badge]');
            const list = widget.querySelector('[data-notification-list]');
            const feedUrl = widget.dataset.feedUrl;
            const markReadUrl = widget.dataset.markReadUrl;
            const deleteUrl = widget.dataset.deleteUrl;
            let loaded = false;
            let loading = false;
            let unreadCount = 0;

            const escapeHtml = (value) => String(value ?? '').replace(/[&<>'\"]/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[char]));

            const getNotificationTag = (notification) => {
                const title = String(notification.title || '').toLowerCase();
                const message = String(notification.message || '').toLowerCase();
                const type = String(notification.type || 'info').toLowerCase();
                const text = `${title} ${message}`;

                if (text.includes('reject')) {
                    return { label: 'Rejected', className: 'error' };
                }

                if (text.includes('hire') || text.includes('offer')) {
                    return { label: 'Hired', className: 'success' };
                }

                if (text.includes('shortlist')) {
                    return { label: 'Shortlisted', className: 'success' };
                }

                if (text.includes('cancel')) {
                    return { label: 'Canceled', className: 'warning' };
                }

                if (text.includes('reschedule')) {
                    return { label: 'Rescheduled', className: 'info' };
                }

                if (text.includes('schedule')) {
                    return { label: 'Scheduled', className: 'info' };
                }

                if (type === 'error' || type === 'warning') {
                    return { label: 'Rejected', className: 'error' };
                }

                if (type === 'success') {
                    return { label: 'Hired', className: 'success' };
                }

                return { label: 'Update', className: 'info' };
            };

            const renderNotification = (notification) => {
                const id = Number(notification.id || 0);
                const title = escapeHtml(notification.title || 'Notification');
                const message = escapeHtml(notification.message || '');
                const tag = getNotificationTag(notification);
                const typeClass = escapeHtml(tag.className);
                const typeLabel = escapeHtml(tag.label);
                const createdAt = escapeHtml(notification.created_at_display || '');
                const isRead = Boolean(Number(notification.is_read ? 1 : 0));
                const link = escapeHtml(notification.link || '#');
                const linkLabel = escapeHtml(notification.link_label || 'Open');

                return `
                    <div class="applicant-notification-item ${isRead ? 'read' : 'unread'}" data-notification-id="${id}" data-is-read="${isRead ? '1' : '0'}">
                        <div class="applicant-notification-item-header">
                            <h5 class="applicant-notification-title">${title}</h5>
                            <span class="applicant-notification-type ${typeClass}">${typeLabel}</span>
                        </div>
                        <p class="applicant-notification-message">${message}</p>
                        <div class="applicant-notification-meta">
                            <span>${isRead ? 'Read' : 'Unread'}</span>
                            <span>${createdAt}</span>
                        </div>
                        <div class="applicant-notification-actions">
                            <a href="${link}" class="applicant-notification-open">${linkLabel}</a>
                            <button type="button" class="applicant-notification-delete" aria-label="Delete notification">x</button>
                        </div>
                    </div>
                `;
            };

            const renderEmpty = (message) => {
                list.innerHTML = `<div class="applicant-notification-empty">${escapeHtml(message)}</div>`;
            };

            const updateBadge = (count) => {
                unreadCount = Math.max(0, Number(count || 0));

                if (!badge) {
                    return;
                }

                if (unreadCount > 0) {
                    badge.hidden = false;
                    badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
                } else {
                    badge.hidden = true;
                }
            };

            const markAsRead = async (notificationId, element) => {
                if (!notificationId || !markReadUrl) {
                    return false;
                }

                if (element && element.dataset.isRead === '1') {
                    return true;
                }

                try {
                    const body = new URLSearchParams({ notification_id: String(notificationId) });
                    const response = await fetch(markReadUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                            'Accept': 'application/json'
                        },
                        body,
                        credentials: 'same-origin'
                    });

                    const result = await response.json();
                    if (!result.success) {
                        return false;
                    }

                    if (element) {
                        element.dataset.isRead = '1';
                        element.classList.remove('unread');
                        element.classList.add('read');
                        const meta = element.querySelector('.applicant-notification-meta span');
                        if (meta) {
                            meta.textContent = 'Read';
                        }
                    }

                    updateBadge(Number(result.unread_count ?? unreadCount - 1));
                    return true;
                } catch (error) {
                    return false;
                }
            };

            const deleteNotification = async (notificationId, element) => {
                if (!notificationId || !deleteUrl) {
                    return false;
                }

                try {
                    const body = new URLSearchParams({ notification_id: String(notificationId) });
                    const response = await fetch(deleteUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                            'Accept': 'application/json'
                        },
                        body,
                        credentials: 'same-origin'
                    });

                    const result = await response.json();
                    if (!result.success) {
                        return false;
                    }

                    if (element) {
                        element.remove();
                    }

                    updateBadge(Number(result.unread_count ?? unreadCount));

                    if (!list.querySelector('.applicant-notification-item')) {
                        renderEmpty('No interview or feedback notifications yet.');
                    }

                    return true;
                } catch (error) {
                    return false;
                }
            };

            const loadNotifications = async () => {
                if (loading || loaded) {
                    return;
                }

                loading = true;

                try {
                    const response = await fetch(feedUrl, {
                        headers: {
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    const data = await response.json();
                    const notifications = Array.isArray(data.notifications) ? data.notifications : [];

                    updateBadge(Number(data.unread_count || 0));

                    if (!notifications.length) {
                        renderEmpty('No interview or feedback notifications yet.');
                    } else {
                        list.innerHTML = notifications.map(renderNotification).join('');
                    }

                    loaded = true;
                } catch (error) {
                    renderEmpty('Unable to load notifications right now.');
                } finally {
                    loading = false;
                }
            };

            const openPanel = () => {
                panel.hidden = false;
                toggle.setAttribute('aria-expanded', 'true');
                loadNotifications();
            };

            const closePanel = () => {
                panel.hidden = true;
                toggle.setAttribute('aria-expanded', 'false');
            };

            toggle.addEventListener('click', (event) => {
                event.preventDefault();
                if (panel.hidden) {
                    openPanel();
                } else {
                    closePanel();
                }
            });

            list.addEventListener('click', async (event) => {
                const item = event.target.closest('.applicant-notification-item');
                if (!item) {
                    return;
                }

                const notificationId = Number(item.dataset.notificationId || 0);

                if (event.target.closest('.applicant-notification-delete')) {
                    event.preventDefault();
                    await deleteNotification(notificationId, item);
                    return;
                }

                event.preventDefault();
                const openLink = event.target.closest('.applicant-notification-open') || item.querySelector('.applicant-notification-open');
                const href = openLink ? (openLink.getAttribute('href') || '#') : '#';

                await markAsRead(notificationId, item);

                if (href && href !== '#') {
                    window.location.href = href;
                }
            });

            document.addEventListener('click', (event) => {
                if (!widget.contains(event.target)) {
                    closePanel();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closePanel();
                }
            });

            loadNotifications();
        })();
    </script>
</div>