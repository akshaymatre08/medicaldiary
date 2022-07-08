    const vapidKey =  'BMehHxkpqdzUaZ_3aavwwKWuC6dI9MOiXq5mcC7XW1fbd-Xr0icRundLcnj4p1ot7yx_I98qFl8oPzsOsHIYUEo';

const firebaseConfig = {
  apiKey: "AIzaSyCeNSPQ2u49Z5s1bZLHXCHN3jPnccW4zXY",
  authDomain: "medicaldiary-3e9b1.firebaseapp.com",
  projectId: "medicaldiary-3e9b1",
  storageBucket: "medicaldiary-3e9b1.appspot.com",
  messagingSenderId: "592645706020",
  appId: "1:592645706020:web:888fe888df6c85decce3b1",
  measurementId: "G-CL4S62WNH0"
};
    
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    const messaging = firebase.messaging();

    messaging.requestPermission()
    .then(function(){
        if(isTokenSentToServer())
            console.log("Token Already Saved");
        else
          generateFirebaseToken();
    })
    .catch(function(err)
    {
      console.log("Permission Declined"+err);
    });
    
    function generateFirebaseToken()
    {
      messaging.getToken({ vapidKey: vapidKey }).then((currentToken) => {
        if (currentToken) {
          updateFirebaseWebToken(currentToken);
            setTokenSentToServer(true);
          console.log(currentToken);
        } else {
          console.log('No registration token available. Request permission to generate one.');
        }
      }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        setTokenSentToServer(false);
      });
    }
    
  	messaging.onMessage(function(payload) {
  	  console.log("Message received. ", payload);
  	  notificationTitle = payload.data.title;
  	  notificationOptions = {
  	  	body: payload.data.body,
  	  	icon: payload.data.icon
  	  };
  	  var notification = new Notification(notificationTitle,notificationOptions);
  	});
    
    
    
    function setTokenSentToServer(sent)
    {
        window.localStorage.setItem('sentToServer', sent ? 1 : 0);
    }
    
    function isTokenSentToServer() {
  	    return window.localStorage.getItem('sentToServer') == 1;
  	}