// JavaScript to toggle the visibility of guest fields based on customer selection

function toggleGuestFields() {
    // Grab the dropdown (probably a <select>) that lists customers
    var customerSelect = document.getElementById('customer_id');
    var guestFields = document.querySelectorAll('.guest-fields');

    if (customerSelect.value === '') {
        // Show guest fields if no customer is selected
        guestFields.forEach(function(field) {
            field.style.display = 'block';
        });
    } else {
        // Hide guest fields if a customer is selected
        guestFields.forEach(function(field) {
            field.style.display = 'none';
        });
    }
}

// Attach the function to the change event of the customer dropdown
document.getElementById('customer_id').addEventListener('change', toggleGuestFields);
