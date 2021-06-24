const addButtons = document.querySelectorAll('.btn');

for (const button of addButtons) {
  button.addEventListener('click', async () => {
    const parent = button.closest('.price');
    const dish_id = +parent.querySelector("input[name='dish_id']").value;
    const quantity = +parent.querySelector('input[name="quantity"]').value;

    const { data } = await axios.post(`${API_URL}/addCartItem`, { dish_id, quantity });

    if (data.message) {
      const classes = ['visible', data.code === 200 ? 'success' : 'error'];
      showNotif(data.message, classes);
    }
  });
}
