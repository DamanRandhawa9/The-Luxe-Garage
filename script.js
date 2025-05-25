
// Example: Show an alert when a car card is clicked
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.car-card').forEach(function(card) {
        card.addEventListener('click', function() {
            alert('You clicked on ' + card.dataset.make + ' ' + card.dataset.model);
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const buyBtn = document.getElementById("buyCarBtn");
    const modal = document.getElementById("bookingModal");
    const cancelBtn = document.getElementById("cancelModalBtn");

    if (buyBtn && modal) {
        buyBtn.addEventListener("click", function () {
            modal.style.display = "block";
        });
    }

    if (cancelBtn && modal) {
        cancelBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
