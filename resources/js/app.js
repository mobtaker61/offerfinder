import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Import Selectと directly to window
window.$ = window.jQuery = require('jquery');
require('select2');

// Import other libraries
try {
    require('toastr');
} catch (e) {
    console.warn('Toastr not found');
}

try {
    require('datatables.net-bs5');
} catch (e) {
    console.warn('DataTables not found');
}

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// Load Firebase Config from Laravel
const firebaseConfig = window.firebaseConfig;

// Check if all config values are loaded
if (!firebaseConfig || !firebaseConfig.projectId) {
    console.error("Firebase configuration is missing. Check .env and app.blade.php.");
}

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Request Permission for Web Push Notifications
function requestPermission() {
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");
            getToken(messaging, { vapidKey: firebaseConfig.vapidKey })
                .then((currentToken) => {
                    if (currentToken) {
                        console.log("FCM Token:", currentToken);
                        sendTokenToServer(currentToken);
                    } else {
                        console.log("No registration token available.");
                    }
                })
                .catch((err) => {
                    console.error("Error retrieving token.", err);
                });
        } else {
            console.log("Notification permission denied.");
        }
    });
}

// Function to Send Token to Laravel Backend
function sendTokenToServer(token) {
    fetch("/save-fcm-token", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ fcm_token: token }),
    }).then(response => response.json())
      .then(data => console.log("Token saved:", data))
      .catch(error => console.error("Error saving token:", error));
}

// Listen for Incoming Messages
onMessage(messaging, (payload) => {
    console.log("Message received:", payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: "/firebase-logo.png",
    };
    new Notification(notificationTitle, notificationOptions);
});

// Request Permission on Page Load
requestPermission();
