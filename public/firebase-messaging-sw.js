// const { initializeApp } = require("https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js");
// const { getMessaging, getToken } = require("https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js");
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

 // Initialize the Firebase app in the service worker by passing the generated config
 const firebaseConfig = {
    apiKey: "AIzaSyBzgGiFsGUPQZYzRmGOm048Z6wo8d8yy7w",
    authDomain: "my-project-e3231.firebaseapp.com",
    projectId: "my-project-e3231",
    storageBucket: "my-project-e3231.appspot.com",
    messagingSenderId: "640360439051",
    appId: "1:640360439051:web:86c2f1b123d0a1251cd60e",
    measurementId: "G-4JCPG6730K"
 };

 // Initialize Firebase
 const app = initializeApp(firebaseConfig);

 // Initialize Firebase Messaging
 const messaging = getMessaging(app);

//  messaging.onBackgroundMessage(function(payload) {
//    console.log("Received background message ", payload);

//    const notificationTitle = payload.notification.title;
//    const notificationOptions = {
//      body: payload.notification.body,
//    };

//    return self.registration.showNotification(notificationTitle, notificationOptions);
//  });