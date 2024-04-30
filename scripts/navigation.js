document.addEventListener("DOMContentLoaded", function() {
    var backButton = document.createElement("button");
    var forwardButton = document.createElement("button");

    backButton.innerHTML = "&lt;"; // Left arrow symbol
    forwardButton.innerHTML = "&gt;"; // Right arrow symbol

    // Add CSS classes to style buttons
    backButton.classList.add("navigation-button", "back-button");
    forwardButton.classList.add("navigation-button", "forward-button");

    backButton.addEventListener("click", function() {
        window.history.back();
    });
    
    forwardButton.addEventListener("click", function() {
        window.history.forward();
    });

    document.body.appendChild(backButton);
    document.body.appendChild(forwardButton);

});
