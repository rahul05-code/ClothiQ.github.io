<?php
include 'config.php';
include 'header.php';

if (!isset($_SESSION['email'])) {
    echo "<p class='alert alert-danger'>Please log in to view orders.</p>";
    include 'footar.php';
    exit();
}

$user_id = $_SESSION['email'];

$query = "SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
    <h1>Your Orders</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td>
                            <?php
                            $items = json_decode($order['items'], true);
                            foreach ($items as $item) {
                                echo "{$item['name']} (x{$item['quantity']}) - ₹{$item['price']}<br>";
                            }
                            ?>
                        </td>
                        <td>₹<?php echo $order['total_price']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders yet.</p>
    <?php endif; ?>
</div>

<?php include 'footar.php'; ?>
