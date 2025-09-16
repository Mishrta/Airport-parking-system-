document.querySelectorAll('.parking-slot input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const label = this.nextElementSibling;
        // Extract the slot ID and price from the label's data attributes
        const slotId = label.getAttribute('data-slot-id');
        const pricePerHour = parseFloat(label.getAttribute('data-price'));

        // Update UI
        document.getElementById('detail-slot').textContent = `#${slotId}`;
        document.getElementById('detail-price').textContent = `£${pricePerHour.toFixed(2)}`;
        document.getElementById('detail-total').textContent = `£${pricePerHour.toFixed(2)}`;

        // Hide default text
        document.querySelector('.select-text').style.display = 'none';
    });
});
