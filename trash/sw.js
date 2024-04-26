importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyBsU4H3l-VgbOBqCrhAN6t1nw17afb4WiQ",
    authDomain: "kardur-52f31.firebaseapp.com",
    projectId: "kardur-52f31",
    storageBucket: "kardur-52f31.appspot.com",
    messagingSenderId: "177631108036",
    appId: "1:177631108036:web:c10e3694c0d088e971a291",
    measurementId: "G-Q6QEH9QMNJ"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  // Handle the message here.
  console.log('Received background message ', payload);
});
