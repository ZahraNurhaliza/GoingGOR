<?php
// Koneksi ke database
require_once("config.php");

if (isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $error_message = "Invalid email address.";
    }
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Periksa database
    $sql = "SELECT * FROM tb_user WHERE email = :email";
    $stmt = $db->prepare($sql);
    
    $params = array(
        ":email" => $email
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        if(password_verify($password, $user["password"])){
            session_start();
            $_SESSION["user"] = $user;
            header("location: index.php");

        }
    }   
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration Form</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style_form.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="logo.png" alt="logo">
                <h2>GoingGOR</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
            </ul>
            <button class="login-btn">LOG IN</button>
        </nav>
    </header>

    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please log in using your personal information to stay connected with us.</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="index.php" method="post">
                    <div class="input-field">
                        <input type="text" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <a href="#" class="forgot-pass-link">Forgot password?</a>
                    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Don't have an account?
                    <a href="signup.php" id="signup-link">Signup</a>
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