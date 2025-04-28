<?php
include 'config.php';
include 'header.php';

?>

<!-- <button id="rzp-button1">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_0uNiiG8oMgCc8P", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo $_POST['amount'] * 100;?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "ClothiQ", //your business name
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "<?php echo 'OID'.rand(10,100).'END';?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
        "name": "<?php echo $_POST['name'];?>", //your customer's name
        "email": "<?php echo $_POST['email'];?>",
        "contact": "<?php echo $_POST['phoneno'];?>" //Provide the customer's phone number for better conversion rates 
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script> -->

<button id="rzp-button1">Pay</button>
<script type="text/javascript" src="jquery-3.7.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_0uNiiG8oMgCc8P", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo $_POST['amount'] * 100;?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "ClothiQ", //your business name
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "<?php echo 'OID'.rand(10,100).'END';?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
        alert(response.razorpay_payment_id);
        alert(response.razorpay_order_id);
        alert(response.razorpay_signature)
    },
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information, especially their phone number
        "name": "<?php echo $_POST['name'];?>", //your customer's name
        "email": "<?php echo $_POST['email'];?>", 
        "contact": "<?php echo $_POST['phoneno'];?>"  //Provide the customer's phone number for better conversion rates 
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        alert(response.error.description);
        alert(response.error.source);
        alert(response.error.step);
        alert(response.error.reason);
        alert(response.error.metadata.order_id);
        alert(response.error.metadata.payment_id);
});
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

<?php include 'footar.php'; ?>
