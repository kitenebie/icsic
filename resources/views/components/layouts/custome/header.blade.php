<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js"></script>
    <script src="/build/assets/app.js"></script>
    <x-script.app />
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        .reaction-popup {
            position: absolute;
            bottom: 100%;
            left: 150% !important;
            transform: translateX(-25%);
            background: rgb(255, 255, 255);
            border-radius: 9999px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
            padding: 6px 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 9999 !important;
            user-select: none;
            visibility: hidden;
            max-width: 400px;
            min-width: 300px;
            display: flex;
        }

        .reaction-popup2 {
            position: absolute;
            bottom: 100%;
            left: 150% !important;
            transform: translateX(-40%);
            background: rgb(255, 255, 255);
            border-radius: 9999px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
            padding: 6px 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 9999 !important;
            user-select: none;
            visibility: hidden;
            max-width: 400px;
            min-width: 238px;
            display: flex;
        }

        .reaction-popup.show {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        .reaction-popup img {
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .reaction-popup img:hover {
            transform: scale(1.4);
        }

        /* Tooltip arrow */
        .reaction-popup::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-25%);
            border-width: 6px;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }


        /* Reaction icon styles for post like icon */
        #like-icon-post {
            font-size: 18px;
            vertical-align: middle;
            margin-right: 4px;
            transition: color 0.3s ease;
        }

        #like-icon-post.liked {
            color: #2563eb;
            /* blue-600 */
        }

        /* Scrollbar styling for the comments container */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }
    </style>
    @yield('meta')
    @fluxAppearance
    @livewireStyles()
    <link rel="stylesheet" href="/css/custome.css">
</head>

<body class="bg-cream-50 text-gray-800 hide-scrollbar hide-scrollbar::-webkit-scrollbar">
    <x-loading />
    @livewire('notification.modal')
    @livewire('profile.modal')
    @include('partials.navbar')
    @livewire('modal.group-member')
    {{ $slot }}
    @fluxScripts()
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>


    @if (auth()->user()->role == 'pending')
        @livewire('user-role.modal-graduates')
        @livewire('user-role.modal-parent')
        @livewire('user-role.modal')
    @endif
    @livewire('request.form')
    @livewire('request.select-student')
    @livewire('request.status-request')
    @if (session('success'))
        @livewire('modal.welcome')
    @endif
    <script>
        function openRequestFrom137() {
            const modal = document.getElementById('RequestFrom137');
            modal.classList.remove('opacity-0', 'pointer-events-none');
        }

        function showGroups() {
            const container = document.getElementById('groupGridContainer');

            // Make it visible
            container.classList.remove('hidden');

            // Allow the DOM to render it before starting the animation
            requestAnimationFrame(() => {
                container.classList.remove('opacity-0', '-translate-y-4');
            });
        }
    </script>
    @include('components.layouts.custome.paymentOverlay')
    @livewireScripts()
    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        // Initialize Firebase Messaging
        const messaging = firebase.messaging();

        // Request permission and get token
        function requestPermission() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                    getToken();
                } else {
                    console.log('Unable to get permission to notify.');
                }
            });
        }

        function getToken() {
            messaging.getToken({
                vapidKey: '{{ env('FCM_SERVER_KEY') }}'
            }).then((currentToken) => {
                if (currentToken) {
                    console.log('Registration token available:', currentToken);
                    sendTokenToServer(currentToken);
                } else {
                    console.log('No registration token available. Request permission to generate one.');
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
            });
        }

        function sendTokenToServer(token) {
            fetch('/api/save-fcm-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        fcm_token: token
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Token saved:', data);
                })
                .catch(error => {
                    console.error('Error saving token:', error);
                });
        }

        // Handle incoming messages when app is in foreground
        messaging.onMessage((payload) => {
            console.log('Message received. ', payload);
            // You can display the notification here
            new Notification(payload.notification.title, {
                body: payload.notification.body,
                icon: payload.notification.icon
            });
        });

        // Request permission on page load if user is authenticated
        @auth
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('Service Worker registered');
                    messaging.useServiceWorker(registration);
                    requestPermission();
                })
                .catch((error) => {
                    console.log('Service Worker registration failed:', error);
                });
        }
        @endauth
    </script>
    <script>
        document.documentElement.classList.remove('dark');
    </script>
</body>

</html>
