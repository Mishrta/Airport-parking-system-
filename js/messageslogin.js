document.addEventListener("DOMContentLoaded", () => {
    const isLoggedIn = false; // 🔐 Replace with PHP session logic later


    // Function to display the login-required message
    function showLoginMessage() {
        const msg = document.getElementById("login-msg");
        msg.classList.add("show");


        // Hide the message after 2 seconds
        setTimeout(() => {
            msg.classList.remove("show");
        }, 2000);
    }
// Select all elements within the form or page that require authentication
    const protectedElements = document.querySelectorAll("form select, form button, .parking-card a");

    // Attach a click event listener to each protected element
    protectedElements.forEach(el => {
        el.addEventListener("click", function (e) {
            // If the user is not logged in, block the interaction and show a warning
            if (!isLoggedIn) {
                e.preventDefault();  // Prevent default behaviour (e.g. form submission or link navigation)
                showLoginMessage(); // Trigger login prompt message
            }
        });
    });
});
