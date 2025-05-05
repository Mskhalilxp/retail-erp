/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    databaseURL: "https://landmark-5557c.firebaseio.com",
    apiKey: "AIzaSyBJKXnXlNoSJSL_Hj6y8cWcwiMo3nuU6c4",
    authDomain: "landmark-5557c.firebaseapp.com",
    projectId: "landmark-5557c",
    storageBucket: "landmark-5557c.appspot.com",
    messagingSenderId: "941997016093",
    appId: "1:941997016093:web:64ca34e00bc10da6b9f2f4"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: "/dashboard-assets/media/logos/favicon.ico",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
