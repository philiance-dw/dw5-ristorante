/*
	GET /cart -> recupere tout
	GET /cart/[i:id] -> recupere par un id
	POST /cart -> crée une nouvelle entrée
	PUT /cart/[i:id] -> modifie par un id
	DELETE /cart/[i:id] -> supprime par un id
*/
const updateTotalPrice = () => {
  const priceDisplayElements = document.querySelectorAll('.price');
  let totalPrice = 0;

  for (const priceDisplayElement of priceDisplayElements) {
    const price = +priceDisplayElement.querySelector('.real__price').textContent;

    totalPrice += price;
  }

  const totalRealPriceElement = document
    .querySelector('.total-price')
    .querySelector('.real__price');

  totalRealPriceElement.textContent = totalPrice.toFixed(2);
};

const getItemInfos = (event) => {
  const quantity = +event.target.value;
  const parent = event.target.closest('.list__child');
  const price = +parent.querySelector('input[name="item__price"]').value;
  const dish_id = +parent.querySelector('input[name="item__id"]').value;
  const dish_name = parent.querySelector('input[name="item__name"]').value;

  return {
    quantity,
    price,
    dish_id,
    dish_name,
  };
};

const updateItemPrice = (event) => {
  const { price, quantity } = getItemInfos(event);

  const parent = event.target.closest('.quantity__container');
  const priceDisplayElement = parent.nextElementSibling.querySelector('.real__price');

  priceDisplayElement.textContent = (price * quantity).toFixed(2);
  updateTotalPrice();
};

const saveItemQuantity = async (event) => {
  const { quantity, dish_id } = getItemInfos(event);

  const { data } = await axios.post(`${API_URL}/addCartItem`, { dish_id, quantity, isExact: true });

  if (data.message) {
    const classes = ['visible', data.code === 200 ? 'success' : 'error'];
    showNotif(data.message, classes);
  }
};

const showDeleteModal = (event) => {
  const modalElement = document.getElementById('modal');
  modalElement.classList.add('visible');

  const dishNameDisplayElement = document.getElementById('modal-title');
  const { dish_name, dish_id } = getItemInfos(event);
  dishNameDisplayElement.textContent = `Voulez vous vraiment supprimer "${dish_name}"?`;

  const modalFormElement = document.querySelector('#modal form');
  modalFormElement.setAttribute('data-dish-id', dish_id);
};

const hideDeleteModal = (event) => {
  const modalElement = document.getElementById('modal');
  modalElement.classList.remove('visible');
};

const deleteItem = async (event) => {
  event.preventDefault();
  const dish_id = event.target.getAttribute('data-dish-id');
  const { data } = await axios.delete(`${API_URL}/cart/${dish_id}`);

  if (data.message) {
    const isSuccess = data.code === 200;
    const classes = ['visible', isSuccess ? 'success' : 'error'];

    if (isSuccess) {
      const dishListItemElement = document.querySelector(`li[data-dish-id="${dish_id}"]`);
      dishListItemElement.remove();
      hideDeleteModal();
      updateTotalPrice();
    }

    showNotif(data.message, classes);
  }
};

const quantityInputElements = document.querySelectorAll(
  '.quantity__container input[type="number"]',
);

for (const quantityInputElement of quantityInputElements) {
  quantityInputElement.addEventListener('input', updateItemPrice);
  quantityInputElement.addEventListener('blur', saveItemQuantity);
}

const trashIconElements = document.querySelectorAll('.ristorante-trash');
const cancelButtonElement = document.getElementById('cancel-button');
const modalFormElement = document.querySelector('#modal form');

modalFormElement.addEventListener('submit', deleteItem);
cancelButtonElement.addEventListener('click', hideDeleteModal);

for (const trashIconElement of trashIconElements) {
  trashIconElement.addEventListener('click', showDeleteModal);
}
