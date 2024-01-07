<?php
// Koneksi ke database
require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Periksa database
    $sql = "INSERT INTO tb_user (email, password)
            VALUE (:email, :password)";
    $stmt = $db->prepare($sql);
    
    $params = array(
        ":email" => $email,
        ":password" => $hashedPassword
    );

    $saved = $stmt->execute($params);

    if($saved) header("location: login.php");
}   
?>

<?php require('login.php');?>

<div class="form-box signup">
            <div class="form-details">
                <h2>Create Account</h2>
                <p>To become a part of our community, please sign up using your personal information.</p>
            </div>
            <div class="form-content">
                <h2>SIGNUP</h2>
                <form action="" method="post">
                    <div class="input-field">
                        <input type="email" name="email" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" required>
                        <label>Create password</label>
                    </div>
                    <div class="policy-text">
                        <input type="checkbox" id="policy">
                        <label for="policy">
                            I agree the
                            <a href="#" class="option">Terms & Conditions</a>
                        </label>
                    </div>
                    <button type="submit" name="signup">Sign Up</button>
                </form>
                <div class="bottom-link">
                    Already have an account? 
                    <a href="login.php" id="login-link">Login</a>
                </div>
            </div>
        </div>
    </div>
    <script>
         const navbarMenu = document.querySelector(".navbar .links");
         const hamburgerBtn = document.querySelector(".hamburger-btn");
         const hideMenuBtn = navbarMenu.querySelector(".close-btn");
         const showPopupBtn = document.querySelector(".login-btn");
         const formPopup = document.querySelector(".form-popup");
         const hidePopupBtn = formPopup.querySelector(".close-btn");
         const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

         // Show mobile menu
         hamburgerBtn.addEventListener("click", () => {
            navbarMenu.classList.toggle("show-menu");
         });

         // Hide mobile menu
         hideMenuBtn.addEventListener("click", () =>  hamburgerBtn.click());

         // Show login popup
         showPopupBtn.addEventListener("click", () => {
            document.body.classList.toggle("show-popup");
         });

         // Hide login popup
         hidePopupBtn.addEventListener("click", () => showPopupBtn.click());

         // Show or hide signup form
         signupLoginLink.forEach(link => {
            link.addEventListener("click", (e) => {
               e.preventDefault();
               formPopup.classList[link.id === 'signup-link' ? 'add' : 'remove']("show-signup");
            });
         });
      </script>
</body>
</html>