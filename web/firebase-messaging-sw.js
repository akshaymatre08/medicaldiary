importScripts('https://www.gstatic.com/firebasejs/4.9.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.9.1/firebase-messaging.js');
/*Update this config*/
const firebaseConfig = {
  apiKey: "AIzaSyCeNSPQ2u49Z5s1bZLHXCHN3jPnccW4zXY",
  authDomain: "medicaldiary-3e9b1.firebaseapp.com",
  projectId: "medicaldiary-3e9b1",
  storageBucket: "medicaldiary-3e9b1.appspot.com",
  messagingSenderId: "592645706020",
  appId: "1:592645706020:web:888fe888df6c85decce3b1",
  measurementId: "G-CL4S62WNH0"
};
   
const icon = 'http://store.socialnewsia.com/src/icons/home.png';

  firebase.initializeApp(config);

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = payload.data.title;
  const notificationOptions = {
    body: payload.data.body,
	icon: icon
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});
// [END background_handler]