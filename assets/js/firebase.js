// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBsU4H3l-VgbOBqCrhAN6t1nw17afb4WiQ",
  authDomain: "kardur-52f31.firebaseapp.com",
  projectId: "kardur-52f31",
  storageBucket: "kardur-52f31.appspot.com",
  messagingSenderId: "177631108036",
  appId: "1:177631108036:web:c10e3694c0d088e971a291",
  measurementId: "G-Q6QEH9QMNJ"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();