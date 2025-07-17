import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage,
} from "https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    databaseURL: import.meta.env.VITE_FIREBASE_DATABASE_URL,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
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
