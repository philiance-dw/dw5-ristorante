// Stripe API Key
const stripe = Stripe(
  'pk_test_51IAAafBb5RE5ldRZ3rYpCtJs8mXO1F2UHvo4WDP28OHT6fptwSaWCUTGCK2hu4HDviS7nAj1ehL9xOOshlQ1J5B100TChwC8tt',
);
const elements = stripe.elements();
// Custom Styling
const style = {
  base: {
    color: '#32325d',
    lineHeight: '24px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4',
    },
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a',
  },
};
// Create an instance of the card Element
const card = elements.create('card', { style, hidePostalCode: true });
// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.addEventListener('change', (event) => {
  const displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
    return;
  }

  displayError.textContent = '';
});
// Handle form submission
const form = document.getElementById('payment-form');
form.addEventListener('submit', (event) => {
  event.preventDefault();
  stripe.createToken(card).then((result) => {
    if (result.error) {
      // Inform the user if there was an error
      const errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
      errorElement.classList.add('error');
      return;
    }

    stripeTokenHandler(result.token);
  });
});
// Send Stripe Token to Server
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  const form = document.getElementById('payment-form');
  // Add Stripe Token to hidden input
  const hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);
  // Submit form
  form.submit();
}
