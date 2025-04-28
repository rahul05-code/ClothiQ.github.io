<?php 
// session_start();
include 'header.php'; 

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

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
    .register-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
    }
    .register-container a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
        margin: 0 15px;
        transition: color 0.3s, transform 0.2s;
    }
    .register-container a:hover {
        color:rgb(0, 0, 0);
        transform: scale(1.1);
    }
</style>

<div class="register-container text-center">
    <h2>Register</h2>
    
    <?php
    if(isset($_SESSION['signup_error'])){
        echo '<p style="color:red;">'.$_SESSION['signup_error'].'</p>';
        unset($_SESSION['signup_error']);
    }
    if(isset($_SESSION['signup_success'])){
        echo '<p style="color:green;">'.$_SESSION['signup_success'].'</p>';
        unset($_SESSION['signup_success']);
    }
    ?>

    <form action="registerprocess.php" method="POST" id="registrationform">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="mb-3 text-start">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="6">
        </div>
        
        <div class="mb-3 text-start">
            <label for="confirmpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required minlength="6">
        </div>

        <button type="submit" class="btn btn-dark w-100" name="signup">Register</button>
        
        <p class="mt-3">Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>

<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script src="jquery.validate.js"></script>

<script>
    $(document).ready(function(){
        $("#registrationform").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 6
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirmpassword: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 6 characters long"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters long"
                },
                confirmpassword: {
                    required: "Please confirm your password",
                    minlength: "Password must be at least 6 characters long",
                    equalTo: "Passwords do not match"
                }
            },
            errorClass: "text-danger",  
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>

<!-- <?php include 'footar.php'; ?> --> 

<style>
    .text-danger {
        color: red;  
    }
</style>
