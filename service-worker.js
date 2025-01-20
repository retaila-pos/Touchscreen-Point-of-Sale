self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('my-cache').then(function(cache) {
      return cache.addAll([
        '/4e35ce7b-c95c-42c2-811a-fe1968245d18/f7033837-3dd8-4bd8-9962-db9469f859f3',
        '/4e35ce7b-c95c-42c2-811a-fe1968245d18/f7033837-3dd8-4bd8-9962-db9469f859f3/index.html',
        '/4e35ce7b-c95c-42c2-811a-fe1968245d18/f7033837-3dd8-4bd8-9962-db9469f859f3/main.css',
        '/4e35ce7b-c95c-42c2-811a-fe1968245d18/f7033837-3dd8-4bd8-9962-db9469f859f3/custom.css',
        // and any other resources your site uses
      ]);
    })
  );
});

self.addEventListener('fetch', function(event) {
  // Check if the request is for terminal.js
  if (event.request.url.includes('terminal.js')) {
    event.respondWith(
      fetch(event.request).catch(function() {
        return caches.match(event.request);
      })
    );
  } else {
    // For other requests, use the cache-first strategy
    event.respondWith(
      caches.match(event.request).then(function(response) {
        return response || fetch(event.request);
      })
    );
  }
});

const CACHE_NAME = 'pos-app-cache-v1';
const urlsToCache = [
    '/',
    '/main.css',
    '/main.js',
    // other assets
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response; // Cache hit - return response
                }
                return fetch(event.request); // Network request if not in cache
            })
    );
});

self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
