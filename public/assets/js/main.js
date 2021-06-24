const API_URL = 'http://localhost:8080/api';

const showNotif = (message = '', classes = []) => {
  const notifElement = document.getElementById('notif');
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
};
