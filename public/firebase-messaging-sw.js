importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js');

// Initialize Firebase inside the Service Worker
firebase.initializeApp({
    apiKey: "AIzaSyBVcwgt3r6L9dtIPR2w1WeSWVCg0YOIbE0",
    authDomain: "chore-scheduling-system.firebaseapp.com",
    projectId: "chore-scheduling-system",
    storageBucket: "chore-scheduling-system.firebasestorage.app",
    messagingSenderId: "1058007120764",
    appId: "1:1058007120764:web:9b572c6e3480074c7f42f9"
});

const messaging = firebase.messaging();

// Background notification handler (When PWA is closed)
messaging.onBackgroundMessage(function(payload) {

    console.log(
        "[firebase-messaging-sw.js] Received background message",
        payload
    );

    const notificationTitle =
        payload.notification?.title || "New Notification";

    const notificationOptions = {
        body: payload.notification?.body || "",
        icon: "/public/logo.png"
    };

    self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});