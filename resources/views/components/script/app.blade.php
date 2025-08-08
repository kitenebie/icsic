<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import {
        getMessaging,
        getToken,
        onMessage
    } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId: "{{ env('FIREBASE_APP_ID') }}"
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    const vapidKey = "BLJJr71stgKSHvCXc3CzT4xpi7XEzzxlP7go-fAEmN0aVqFGkF7IrFr1v8McqDrebAPHf2awcAfa-Wd2ylOCDG4";

    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            return getToken(messaging, {
                vapidKey
            });
        } else {
            throw new Error("Permission not granted");
        }
    }).then((currentToken) => {
        fetch('/save-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                fcm_token: currentToken
            })
        });
        // Send to Laravel
        fetch('/send-notification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                fcm_token: currentToken
            })
        });
    }).catch((err) => {
        console.error('FCM token error:', err);
    });
    onMessage(messaging, (payload) => {
        console.log('Message received in foreground: ', payload);
        new Notification(payload.notification.title, {
            body: payload.notification.body
        });
    });
</script>
