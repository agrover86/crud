/*
Copyright 2016 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

(function() {
  'use strict';



  var staticCacheName = 'pages-cache-v1';

  self.addEventListener('install', function(event) {
    console.log('Service worker installing...');
    event.waitUntil(
    caches.open(staticCacheName).then(function(cache) {
      return cache.addAll([
      'add_owners.php',
      'edit_owners_offline.php',
      'gulpfile.js',
      'owners.php',
      '/crud/js/main.js',
      '/crud/js/idb.js',
      'README.md',
      'delete_owners.php',
      'index.php',
      'update_entries.php',
      'package.json',
      'service-worker.js',
      'edit_owners.php',
      'package-lock.json',
      '/crud/css/freelancer.css',
      '/crud/css/freelancer.min.css',
      '/crud/includes/database.php',
      '/crud/includes/db_object.php',
      '/crud/includes/init.php',
      '/crud/includes/owner.php',
      '/crud/includes/db_config.php',
      '/crud/includes/functions.php',
      '/crud/includes/new_config.php'
  ]);
  }).catch(function(error) {
      console.log('Registration failed with ' + error);
  })
);
});

  self.addEventListener('activate', function(event) {
    console.log('Service worker activate...');
  });


    self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request)
        .then(function(response) {
          // Cache hit - return response
          if (response) {
            if(navigator.onLine==true){
              console.log('fetching page from network');
              return fetch(event.request).catch(function() {
                  return caches.match('index.php');
              });
            }
            console.log('fetching page from cache');
            return response;

          } else{
          console.log('fetching page from network');
          return fetch(event.request).catch(function() {
              return caches.match('index.php');
          })
         }
      })
    )
  })



})();
