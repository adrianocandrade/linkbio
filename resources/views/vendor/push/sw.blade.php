importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "{{ settings('firebase.apiKey') }}",
    authDomain: "{{ settings('firebase.authDomain') }}",
    projectId: "{{ settings('firebase.projectId') }}",
    storageBucket: "{{ settings('firebase.storageBucket') }}",
    messagingSenderId: "{{ settings('firebase.messagingSenderId') }}",
    appId: "{{ settings('firebase.appId') }}"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
return self.registration.showNotification(title,{body,icon});
});