// Initialize Firebase
const firebaseConfig = {
    apiKey: "{{ env('FIREBASE_API_KEY') }}",
    authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
    storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
    messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
    appId: "{{ env('FIREBASE_APP_ID') }}"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Initialize Firebase Cloud Messaging
const messaging = firebase.messaging();

// Request permission and get token
async function requestNotificationPermission() {
    try {
        // Request permission
        const permission = await Notification.requestPermission();
        
        if (permission === 'granted') {
            // Get FCM token
            const token = await messaging.getToken({
                vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
            });

            // Send token to server
            await registerFcmToken(token);
            
            console.log('FCM Token:', token);
            return token;
        } else {
            console.log('Notification permission denied');
            return null;
        }
    } catch (error) {
        console.error('Error getting FCM token:', error);
        return null;
    }
}

// Register FCM token with server
async function registerFcmToken(token) {
    try {
        const response = await fetch('/fcm-tokens', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                fcm_token: token
            })
        });

        if (!response.ok) {
            throw new Error('Failed to register FCM token');
        }

        console.log('FCM token registered successfully');
    } catch (error) {
        console.error('Error registering FCM token:', error);
        throw error;
    }
}

// Handle foreground messages
messaging.onMessage((payload) => {
    console.log('Received foreground message:', payload);

    // Show notification
    if (Notification.permission === 'granted') {
        new Notification(payload.notification.title, {
            body: payload.notification.body,
            icon: '/images/logo.png'
        });
    }
});

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    // Request notification permission
    requestNotificationPermission();
}); 