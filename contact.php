<?php include 'header.php'; ?>
<div class="container mt-5">
    <h1>Contact Us</h1>
    <form action="sendmessege.php" method="POST" id="contactus">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="textmessage" class="form-label">Message</label>
            <textarea class="form-control" id="textmessage" name="textmessage" required></textarea>
        </div>
        <button type="submit" class="btn btn-dark">Submit</button>
    </form>
</div>

<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script src="jquery.validate.js"></script>

<script>
    $(document).ready(function(){
        $("#contactus").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 6
                },
                email: {
                    required: true,
                    email: true
                },
                textmessage: {
                    required: true,
                    minlength: 20
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
                textmessage: {
                    required: "Please enter your message",
                    minlength: "Message must be at least 20 characters long"
                }
            },
            errorClass: "text-danger",
            submitHandler: function(form){
                form.submit();
            }
        });
    });
</script>

<?php include 'footar.php'; ?>

<style>
    .text-danger {
        color: red;  
    }
</style>
