
    window.addEventListener('DOMContentLoaded', () => {
        // Get the flash message element by its ID
    const flash = document.getElementById('flash-message');
        // If a flash message exists on the page
    if (flash) {
        // Wait 2 seconds before starting the fade-out
    setTimeout(() => {
    flash.style.transition = "opacity 0.5s ease";
    flash.style.opacity = 0;

    setTimeout(() => {
    flash.remove();
}, 500); // wait for fade-out before removing
}, 2000); // show for 2 seconds
}
});

