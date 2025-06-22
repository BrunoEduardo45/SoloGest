const CACHE_NAME = 'my-app-cache';
const CACHE_VERSION = 'v1';

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME + '-' + CACHE_VERSION)
      .then(function(cache) {
        return cache.addAll([]);
      })
      .then(function() {
        return self.skipWaiting();
      })
  );
});

self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys()
      .then(function(cacheNames) {
        return Promise.all(
          cacheNames.filter(function(cacheName) {
            return cacheName.startsWith(CACHE_NAME) && cacheName !== CACHE_NAME + '-' + CACHE_VERSION;
          }).map(function(cacheName) {
            return caches.delete(cacheName);
          })
        );
      })
      .then(function() {
        return self.clients.claim();
      })
  );
});

self.addEventListener('fetch', function(event) {
    if (event.request.method === 'GET') {
        event.respondWith(
            fetch(event.request)
            .then(function(response) {
                // Verifica se a resposta é válida e se não é uma solicitação de dados do navegador
                if (response && response.status === 200 && response.type === 'basic') {
                // Clona a resposta
                const responseToCache = response.clone();

                // Armazena a resposta em cache para uso posterior
                caches.open(CACHE_NAME + '-' + CACHE_VERSION)
                  .then(function (cache) {
                    try {
                      cache.put(event.request, responseToCache);
                    } catch (error) {
                      console.error('Error caching response:', error);
                    }
                  });
                }

                return response;
            })
            .catch(function() {
                // Em caso de falha na solicitação, busca a resposta do cache, se disponível
                return caches.match(event.request);
            })
        );
    };
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close(); 
  var fullPath = self.location.origin + event.notification.data.path; 
  clients.openWindow(fullPath); 
});

self.addEventListener('push', (event) => {
  event.waitUntil(
    self.registration.showNotification('Notification Title', {
      body: 'Notification Body Text',
      icon: 'custom-notification-icon.png',
    })
  );
});
