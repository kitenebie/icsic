import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage,
} from "https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging.js";

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

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Request permission and get token
getToken(messaging, { vapidKey: import.meta.env.VITE_FIREBASE_VAPID_KEY })
    .then((currentToken) => {
        if (currentToken) {
            console.log("FCM Token:", currentToken);

            // Send token to server
            fetch("/send-notification", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ fcm_token: currentToken }),
            });
        } else {
            console.warn("No registration token available.");
        }
    })
    .catch((err) => {
        console.error("FCM token error:", err);
    });

// Listen for foreground messages
onMessage(messaging, (payload) => {
    console.log("Message received: ", payload);
    new Notification(payload.notification.title, {
        body: payload.notification.body,
    });
});
