<?php include('../includes/header.php'); ?>

<style>
.login-background {
    position: relative;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url('../images/hotel1.jpg') no-repeat center center;
    background-size: cover;
}
.login-background::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    z-index: 0;
}

.login-card {
    position: relative;
    z-index: 1;
    width: 24rem; 
    padding: 1.25rem; 
    background: linear-gradient(135deg, #f5f8f8f4, #2a8cdcff); 
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    border-radius: 1rem;
}
</style>

<div class="login-background">
    <div class="login-card">
        <h2 class="text-2xl font-bold mb-5 text-center">Login</h2>
        <form id="loginForm">
            <input type="email" name="email" id="loginEmail" placeholder="Your Email" class="input input-ghost w-full mb-3" required />
            <input type="password" name="password" id="loginPassword" placeholder="Your Password" class="input input-ghost w-full mb-3" required />
            <div id="loginMessage" style="color:red; margin-bottom:10px;"></div>
            <button type="submit" class="btn w-full">Login</button>
        </form>
        <p class="mt-3 text-center">
            Don't have an account? <a href="signup.php" class="text-blue-500">Sign Up</a>
        </p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const loginMsg = document.getElementById("loginMessage");

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(loginForm);
        formData.append("login", true);

        fetch("../handlers/login.php", {  
            method: "POST",
            body: formData
        })
        .then(async response => {
            if (!response.ok) throw new Error(await response.text());
            return response.json();
        })
        .then(data => {
            if (data.success) {
                loginMsg.style.color = "green";
                loginMsg.textContent = data.success;
                loginForm.reset();
                window.location.href = data.redirect;
            } else if (data.error) {
                loginMsg.style.color = "red";
                loginMsg.textContent = data.error;
            }
        })
        .catch(err => {
            loginMsg.style.color = "red";
            loginMsg.textContent = "An error occurred: " + err;
        });
    });
});
</script>

<?php include('../includes/footer.php'); ?>
