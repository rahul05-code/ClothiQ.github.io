<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION['email'])) {
    echo "<div class='container mt-5'><h2>Please <a href='login.php'>login</a> to view your favorites.</h2></div>";
    include 'footar.php';
    exit();
}

$user_email = $_SESSION['email'];
$query = "SELECT i.* FROM items i JOIN favorites f ON i.id = f.item_id WHERE f.user_email = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

?>

<style>
    .card-img-top {
    border-radius: 0.5rem 0.5rem 0 0;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-5">
    <h2>Your Favorite Items</h2>
    <div class="row">
        <?php
        if ($result->num_rows == 0) {
            echo "<p>No favorites added yet.</p>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="' . $row['image'] . '" class="card-img-top" style="height:300px; object-fit:contain;">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <p><strong>Category:</strong> ' . $row['category'] . '</p>
                            <p><strong>Price:</strong> ₹' . $row['price'] . '</p>
                            <button class="btn btn-outline-danger remove-favorite-btn" data-id="' . $row['id'] . '">❌ Remove</button>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</div>

<script src="jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){
    $(".remove-favorite-btn").click(function(){
        var button = $(this);
        var itemId = $(this).data("id");

        $.post("favorite_handler.php", { id: itemId }, function(){
            button.closest(".col-md-3").fadeOut();
        });
    });
});
</script>

<?php include 'footar.php'; ?>
