document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("signupForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        let name = document.getElementById("name").value;
        let role = document.getElementById("role").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        
        if (name && role && email && password) {
            alert("Signup successful! Redirecting to login page.");
            window.location.href = "login.html";
        } else {
            alert("Please fill in all fields.");
        }
        
    });
});
