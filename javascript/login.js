document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        let role = document.getElementById("role").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        
        // Mock authentication (replace this with real backend verification)
        if (email && password) {
            if (role === "tenant") {
                window.location.href = "tenant_dashboard.php";
            } else if (role === "landlord") {
                window.location.href = "landlord_dashboard.php";
            } 
        } else {
            alert("Please enter valid credentials.");
        }
    });
});
