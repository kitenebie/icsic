// Firebase Messaging Service Worker
importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js');

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBMKeLJ6ali0KwG1fGaNJZJXJfCONmBNi8",
  authDomain: "notification-app-c4e8e.firebaseapp.com",
  databaseURL: "https://notification-app-c4e8e-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "notification-app-c4e8e",
  storageBucket: "notification-app-c4e8e.firebasestorage.app",
  messagingSenderId: "907129181512",
  appId: "1:907129181512:web:7c9e4a1eac5a3e77afcf7d",
  measurementId: "G-VN3X9V49J8"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Initialize Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || '/favicon.ico'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});