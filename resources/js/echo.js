import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;



window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


console.log('Hi from js');
window.Echo.channel('new-user-channel')
    .listen('NewUserRegisteredEvent', (e) => {
        console.log(e);
        $(".notificationsIcon").load(" .notificationsIcon > *");
        $("#notificationsModal").load(" #notificationsModal > *");
    });
