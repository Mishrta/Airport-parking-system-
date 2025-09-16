
    document.querySelector('.input-group').addEventListener('submit', function(event) {
    const form = event.target;

    const cardName = form.querySelector('[name="card_name"]');
    const cardNumber = form.querySelector('[name="card_number"]');
    const expiryDate = form.querySelector('[name="expiry_date"]');
    const cvv = form.querySelector('[name="cvv"]');
    const vehicleNumber = form.querySelector('[name="vehicle_number"]');

    // Validation patterns
    const cvvRegex = /^\d{3}$/;
    const expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
    const cardNumberRegex = /^\d{16}$/;

    if (!cardName.value.trim()) {
    alert("Cardholder name is required.");
    event.preventDefault();
    return;
}

    if (!cardNumber.value.match(cardNumberRegex)) {
    alert("Card number must be exactly 16 digits.");
    event.preventDefault();
    return;
}

    if (!expiryDate.value.match(expiryDateRegex)) {
    alert("Please enter a valid expiration date in MM/YY format.");
    event.preventDefault();
    return;
}

    if (!cvv.value.match(cvvRegex)) {
    alert("CVV must be exactly 3 digits.");
    event.preventDefault();
    return;
}

    if (!vehicleNumber.value.trim()) {
    alert("Vehicle number is required.");
    event.preventDefault();
    return;
}
});

    // Auto-format expiry date field
    document.querySelector('[name="expiry_date"]').addEventListener('input', function(event) {
    let value = event.target.value.replace(/\D/g, '');

    if (value.length >= 3) {
    value = value.slice(0, 2) + '/' + value.slice(2, 4);
}

    event.target.value = value;
});

