

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<div class="bio-push-bar-wrapper" data-id="{{ $bio->id }}">
    
    <div class="notification-bar is-allow-push hide">
        <div class="noti-close-btn left-0" tabindex="0">
            <i class="sni sni-cross"></i>
        </div>
        <div class="notification-text font-bold text-xs pl-6 pr-2">{{ __("Receive notification from this page?") }}</div>
        <div class="sandy-expandable-btn cursor-pointer">
            <span>{{ __('Allow') }}</span>
        </div>
    </div>
</div>


<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
      apiKey: "{{ settings('firebase.apiKey') }}",
      authDomain: "{{ settings('firebase.authDomain') }}",
      projectId: "{{ settings('firebase.projectId') }}",
      storageBucket: "{{ settings('firebase.storageBucket') }}",
      messagingSenderId: "{{ settings('firebase.messagingSenderId') }}",
      appId: "{{ settings('firebase.appId') }}"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    var messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function () {
            return messaging.getToken()
        }).then(function(token) {
            axios.post("{{ \Bio::route($bio->id, 'save-notification-token') }}",{
                _method:"POST",
                token
            }).then(({data})=>{
                //console.log(data)
            }).catch(({response:{data}})=>{
                //console.error(data)
            });

        }).catch(function (err) {
            //console.log(`Token Error :: ${err}`);
        });
    }
          
    messaging.onMessage(function({data:{body,title}}){
        new Notification(title, {body});
    });
</script>