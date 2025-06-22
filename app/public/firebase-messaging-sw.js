importScripts('https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging-compat.js')

const firebaseConfig = {
    apiKey: "AIzaSyCSMBHclVlQnUwNdM6zpxAcnvfhoBg1g2E",
    authDomain: "push-fielapp.firebaseapp.com",
    projectId: "push-fielapp",
    storageBucket: "push-fielapp.appspot.com",
    messagingSenderId: "787353718327",
    appId: "1:787353718327:web:c0a74242123aa4774579b2"
};

const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging()

// Para notificações em primeiro plano (ativa)
messaging.onMessage(function(payload){
    const notificationTitle = payload.data.title
    const notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image
    }
    self.registration.showNotification(notificationTitle, notificationOptions);
    self.addEventListener('notificationclick', function(event){
        const clickednotification = event.notification
        clickednotification.close();
        event.waitUntil(
            clients.openWindow(payload.data.click_action)
        )
    })
})

// Para notificações em segundo plano
messaging.onBackgroundMessage(function(payload){
    const notificationTitle = payload.data.title
    const notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image
    }
    self.registration.showNotification(notificationTitle, notificationOptions);
    self.addEventListener('notificationclick', function(event){
        const clickednotification = event.notification
        clickednotification.close();
        event.waitUntil(
            clients.openWindow(payload.data.click_action)
        )
    })
})