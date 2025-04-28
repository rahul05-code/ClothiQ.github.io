<?php
include 'config.php';
include 'header.php';

if (!isset($_SESSION['email'])) {
    echo "<div class='container mt-5'><h2>Please <a href='login.php'>login</a> to view your cart.</h2></div>";
    include 'footar.php';
    exit();
}

$user_email = $_SESSION['email'];

// Add item to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $item_id = intval($_POST["id"]);
    $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;

    $check = $con->prepare("SELECT quantity FROM cart WHERE user_email = ? AND item_id = ?");
    $check->bind_param("si", $user_email, $item_id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $existing = $res->fetch_assoc();
        $new_qty = $existing['quantity'] + $quantity;
        $update = $con->prepare("UPDATE cart SET quantity = ? WHERE user_email = ? AND item_id = ?");
        $update->bind_param("isi", $new_qty, $user_email, $item_id);
        $update->execute();
    } else {
        $insert = $con->prepare("INSERT INTO cart (user_email, item_id, quantity) VALUES (?, ?, ?)");
        $insert->bind_param("sii", $user_email, $item_id, $quantity);
        $insert->execute();
    }

    header("Location: cart.php");
    exit();
}

// Remove item
if (isset($_GET["remove"])) {
    $item_id = intval($_GET["remove"]);
    $del = $con->prepare("DELETE FROM cart WHERE user_email = ? AND item_id = ?");
    $del->bind_param("si", $user_email, $item_id);
    $del->execute();

    header("Location: cart.php");
    exit();
}

// Clear cart
if (isset($_GET["clear"])) {
    $clear = $con->prepare("DELETE FROM cart WHERE user_email = ?");
    $clear->bind_param("s", $user_email);
    $clear->execute();

    header("Location: cart.php");
    exit();
}


$stmt = $con->prepare("SELECT c.item_id, c.quantity, i.name, i.price FROM cart c JOIN items i ON c.item_id = i.id WHERE c.user_email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$cart_items = $stmt->get_result();

// Now, calculate total amount
$amount = 0;
$cart_data = [];  // to store cart rows temporarily

while ($row = $cart_items->fetch_assoc()) {
    $cart_data[] = $row; // save for later use
    $amount += $row['price'] * $row['quantity'];
}
?>
<div class="container mt-5">
    <h1>Your Cart</h1>

    <?php
    if (empty($cart_data)) {
        echo "<p>Your cart is empty.</p>";
    } else {
        echo '
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($cart_data as $row) {
            $subtotal = $row["price"] * $row["quantity"];
            echo "
            <tr>
                <td>{$row["name"]}</td>
                <td>₹{$row["price"]}</td>
                <td>{$row["quantity"]}</td>
                <td>₹{$subtotal}</td>
                <td>
                    <a href='cart.php?remove={$row["item_id"]}' class='btn btn-danger btn-sm'>Remove</a>
                </td>
            </tr>";
        }

        echo '
            </tbody>
        </table>
        <h3>Total: ₹' . $amount . '</h3>
        <a href="cart.php?clear=true" class="btn btn-warning">Clear Cart</a>
        <button id="rzp-button1" class="btn btn-success">Proceed to Checkout</button>';
    }
    ?>
</div>

<?php
if (!isset($amount) || !is_numeric($amount) || $amount <= 0) {
    $amount = 1; // at least ₹0.01 to avoid Razorpay crash
}
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_KhiXMkiMXlbBXe",
    "amount": <?php echo ($amount * 100); ?>,
    "currency": "INR",
    "name": "ClothiQ",
    "description": "Cart Checkout",
    "handler": function (response){
        alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
        window.location.href = "payment.php?payment_id=" + response.razorpay_payment_id;
    },
    "prefill": {
        "name": "<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>",
        "email": "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>",
        "contact": "<?php echo isset($_SESSION['phone_no']) ? $_SESSION['phone_no'] : ''; ?>",
    },
    "theme": {
        "color": "#3399cc"
    }
};

var rzp1 = new Razorpay(options);

window.onload = function() {
    var btn = document.getElementById('rzp-button1');
    if (btn) {
        btn.onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        };
    }
};
</script>


<?php include 'footar.php'; ?>
