"use strict";
const API_URL = 'https://ristorante.david-nogueira.dev/api';
const showNotif = (message = '', classes = []) => {
    const notifElement = document.getElementById('notif');
    if (notifElement) {
        notifElement.textContent = message;
        notifElement.classList.remove('hidden');
        notifElement.classList.add(...classes);
        setTimeout(() => {
            notifElement.classList.remove('visible');
            notifElement.classList.add('hidden');
            setTimeout(() => {
                notifElement.classList.remove('success', 'error');
            }, 1000);
        }, 4000);
    }
};
