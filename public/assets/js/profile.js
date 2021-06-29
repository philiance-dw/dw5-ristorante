"use strict";
const showDeleteModal = () => {
    const modalElement = document.getElementById('modal');
    modalElement === null || modalElement === void 0 ? void 0 : modalElement.classList.add('visible');
    const dishNameDisplayElement = document.getElementById('modal-title');
    if (dishNameDisplayElement)
        dishNameDisplayElement.textContent = `Voulez vous vraiment supprimer votre compte?`;
    const modalFormElement = document.querySelector('#modal form');
    if (modalFormElement) {
        modalFormElement.action = '/profil/supprimer';
        modalFormElement.method = 'POST';
    }
};
const hideDeleteModal = () => {
    const modalElement = document.getElementById('modal');
    if (modalElement)
        modalElement.classList.remove('visible');
};
const showModalButton = document.querySelector('button#showModal');
const cancelButton = document.querySelector('button#cancel-button');
showModalButton === null || showModalButton === void 0 ? void 0 : showModalButton.addEventListener('click', showDeleteModal);
cancelButton === null || cancelButton === void 0 ? void 0 : cancelButton.addEventListener('click', hideDeleteModal);
