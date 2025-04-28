<?php 
// session_start();
include 'header.php'; 
?>

<style>
    body {
        height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('logo.jpg') no-repeat center center fixed;
        background-size: 70% 100%;
        font-family: Arial, sans-serif;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
    }

    .login-container a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
        margin: 0 15px;
        transition: color 0.3s, transform 0.2s;
    }

    .login-container a:hover {
        color: rgb(0, 0, 0);
        transform: scale(1.1);
    }

    .text-danger {
        color: red;
    }
</style>

<div class="login-container text-center">
    <h2>Login</h2>

    
    <?php if(isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>

    <?php if(isset($_SESSION['login_success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['login_success']; unset($_SESSION['login_success']); ?></div>
    <?php endif; ?>
    
  
    <form action="loginprocess.php" method="POST" id="loginform">
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="6">
        </div>

        <button type="submit" class="btn btn-dark w-100" name="login">Login</button>

        <p class="mt-2">
            <a href="forgot_password.php">Forgot Password?</a>
        </p>

        <p class="mt-3">Don't have an account? <a href="register.php">Register now</a></p>
    </form>
</div>


<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script src="jquery.validate.js"></script>

<script>
    $(document).ready(function(){
        $("#loginform").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters long"
                }
            },
            errorClass: "text-danger",
            submitHandler: function(form){
                form.submit();
            }
        });
    });
</script>
