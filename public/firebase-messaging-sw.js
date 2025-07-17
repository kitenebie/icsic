importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyBomSVQcMytesRLPUZgz9I-MVuQt5yEKCQ",
  authDomain: "fb1-tst.firebaseapp.com",
  projectId: "fb1-tst",
  storageBucket: "fb1-tst.appspot.com",
  messagingSenderId: "426139628396",
  appId: "1:426139628396:web:52ec020c8d45e26c53b949"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  const { title, body } = payload.notification;

  self.registration.showNotification(title, {
    body: body
  });
});
