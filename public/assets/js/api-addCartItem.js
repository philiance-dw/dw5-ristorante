const addButtons = Array.from(document.querySelectorAll('.btn'));

for (const button of addButtons) {
  button.addEventListener('click', async () => {
    const parent = button.closest('.price');

    let dish_id, quantity;

    if (parent) {
      const dishIdInput = parent.querySelector("input[name='dish_id']");
      const quantityInput = parent.querySelector('input[name="quantity"]');

      if (dishIdInput && quantityInput) {
        dish_id = dishIdInput.value;
        quantity = quantityInput.value;
      }
    }

    if (dish_id && quantity) {
      const { data } = await axios.post(`${API_URL}/addCartItem`, { dish_id, quantity });

      if (data.message) {
        const classes = ['visible', data.code === 200 ? 'success' : 'error'];
        showNotif(data.message, classes);
      }
    }
  });
}
