document.querySelector('form').addEventListener('submit', function(event) {
    const airport = document.querySelector('select[name="airport"]');
    const carPark = document.querySelector('select[name="car_park"]');
    const parkingType = document.querySelector('select[name="parking_type"]');
    const fromDate = document.querySelector('input[name="from_date"]');
    const toDate = document.querySelector('input[name="to_date"]');

    if (!airport.value || !carPark.value || !parkingType.value || !fromDate.value || !toDate.value) {
        alert('Please fill in all fields before submitting the form.');
        event.preventDefault(); // Prevent form submission
    }
});