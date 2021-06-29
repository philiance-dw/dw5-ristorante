const showDeleteModal = () => {
  const modalElement = document.getElementById('modal');

  modalElement?.classList.add('visible');

  const dishNameDisplayElement = document.getElementById('modal-title');

  if (dishNameDisplayElement)
    dishNameDisplayElement.textContent = `Voulez vous vraiment supprimer votre compte?`;

  const modalFormElement = document.querySelector('#modal form') as HTMLFormElement | null;

  if (modalFormElement) {
    modalFormElement.action = '/profil/supprimer';
    modalFormElement.method = 'POST';
  }
};

const hideDeleteModal = () => {
  const modalElement = document.getElementById('modal');
  if (modalElement) modalElement.classList.remove('visible');
};

const showModalButton = document.querySelector('button#showModal') as HTMLButtonElement | null;
const cancelButton = document.querySelector('button#cancel-button') as HTMLButtonElement | null;

showModalButton?.addEventListener('click', showDeleteModal);
cancelButton?.addEventListener('click', hideDeleteModal);
