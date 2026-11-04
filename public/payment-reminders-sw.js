self.addEventListener('push', event => {
    let data;
    try { data = event.data.json(); } catch { return; }
    if (!data || Date.now() >= data.expiresAt) return;
    event.waitUntil(self.registration.showNotification(data.title, {
        body: data.body, tag: data.tag, data: { url: data.url },
    }));
});
self.addEventListener('notificationclick', event => {
    event.notification.close();
    const url = new URL(event.notification.data.url, self.location.origin);
    if (url.origin !== self.location.origin) return;
    event.waitUntil(clients.matchAll({ type: 'window', includeUncontrolled: true }).then(async windows => {
        const existing = windows.find(client => client.url === url.href);
        if (existing) return existing.focus();
        return clients.openWindow(url.href);
    }));
});
