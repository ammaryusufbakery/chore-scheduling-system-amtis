

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import {
    messaging,
    getToken
} from './firebase-messaging';

document
    .getElementById('enable-notifications')
    ?.addEventListener('click', async () => {

        try {

            const permission =
                await Notification.requestPermission();

            if (permission !== 'granted') {

                console.log(
                    'Notification permission denied'
                );

                return;
            }

            const token = await getToken(
                messaging,
                {
                    vapidKey:
                        import.meta.env.VITE_FIREBASE_VAPID_KEY
                }
            );

            console.log(
                'FCM Token:',
                token
            );

            await fetch('/api/fcm-token', {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .getAttribute('content')
                },

                body: JSON.stringify({
                    token: token
                })
            });

        } catch (error) {

            console.error(
                'Unable to get notification token:',
                error
            );

        }

    });