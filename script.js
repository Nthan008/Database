$(document).ready(function() {
    // Get the modals
    var loginModal = document.getElementById('loginModal');
    var registerModal = document.getElementById('registerModal');

    // Get the buttons that open the modals
    var loginBtn = document.querySelector('.header-right img[alt="Account"]');
    var registerBtn = document.getElementById('registerBtn'); // Make sure you have this ID in your HTML

    // Get the <span> elements that close the modals
    var loginModalCloseBtn = document.getElementsByClassName("close")[0];
    var registerModalCloseBtn = document.getElementsByClassName("close")[1]; // Adjust the index

    // When the user clicks the login button, open the login modal
    loginBtn.onclick = function() {
        loginModal.style.display = "block";
    }

    // When the user clicks the register button, open the register modal
    registerBtn.onclick = function() {
        registerModal.style.display = "block";
    }

    // When the user clicks on <span> (x) in the login modal, close the login modal
    loginModalCloseBtn.onclick = function() {
        loginModal.style.display = "none";
    }

    // When the user clicks on <span> (x) in the register modal, close the register modal
    registerModalCloseBtn.onclick = function() {
        registerModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the login modal, close it
    window.onclick = function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = "none";
        }
        if (event.target == registerModal) {
            registerModal.style.display = "none";
        }
    }

    // Function to show the login successful modal
    function showLoginSuccessfulModal() {
        var loginSuccessfulModal = document.getElementById('loginSuccessfulModal');
        loginSuccessfulModal.style.display = "block";
    }

    // Event listener for the continue button in the login successful modal
    document.getElementById('continueBtn').onclick = function() {
        var loginSuccessfulModal = document.getElementById('loginSuccessfulModal');
        loginSuccessfulModal.style.display = "none";
        
        // You can add code here to update the UI for the logged-in state
        // For example, showing the user's name in the header
        var customerName = "<?php echo isset($_SESSION['customerName']) ? $_SESSION['customerName'] : ''; ?>";
        if (customerName) {
            document.querySelector('.header-right a[alt="Account"]').innerHTML = "Welcome, " + customerName;
        }
    }
// Initial setup to hide admin features
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.header-nav').style.display = 'none'; // Hide admin options by default
});

$.ajax({
    url: 'sussy.php', // Updated to point to the new PHP script
    type: 'get',
    success: function(data) {
        // Display the fetched data in the productDetailsOverlay div
        $('#productDetailsOverlay').html(data);
        $('#productDetailsOverlay').show(); // Show the overlay
    },
    error: function(xhr, status, error) {
        console.error("Error: " + error);
    }
});



});