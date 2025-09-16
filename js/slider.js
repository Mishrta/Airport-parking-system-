// Keeps track of the current slide index (starts at 0)
let slideIndex = 0;
// Grabs all elements with the class "slides" (your slideshow items)
let slides = document.getElementsByClassName("slides");
// This will store the interval for the auto-sliding so we can control it later
let slideInterval;

// Function to display slides automatically
// Function to automatically show slides in a loop
function showSlidesAuto() {
    // First, hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    // Move to the next slide
    slideIndex++;
    // If the index goes beyond the number of slides, loop back to the first one
    if (slideIndex > slides.length) slideIndex = 1;
    // Show the current slide (adjusting for 0-based index)
    slides[slideIndex - 1].style.display = "block";
}

// Function to manually change slides
function changeSlide(n) {
    clearInterval(slideInterval);
    slideIndex += n;
    if (slideIndex > slides.length) slideIndex = 1;
    if (slideIndex < 1) slideIndex = slides.length;
    displaySlide(slideIndex);
    slideInterval = setInterval(showSlidesAuto, 4000);
}

// Display specific slide
function displaySlide(n) {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[n - 1].style.display = "block";
}

// Start the slideshow on page load
window.onload = function() {
    showSlidesAuto();
    slideInterval = setInterval(showSlidesAuto, 4000); // Slide every 4 seconds
};
