<?php 
include 'header.php';
include 'config.php';

$fav_items = [];
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $fav_result = $con->query("SELECT item_id FROM favorites WHERE user_email = '$email'");
    while ($fav_row = $fav_result->fetch_assoc()) {
        $fav_items[] = $fav_row['item_id'];
    }
}
?>

<script src="jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $(".favorite-btn").click(function() {
        var button = $(this);
        var itemId = button.data("id");

        $.post("favorite_handler.php", { id: itemId }, function(response) {
            if (response.trim() === "added") {
                button.text("❤️");
            } else if (response.trim() === "removed") {
                button.text("🤍");
            } else if (response.trim() === "login_required") {
                window.location.href = "login.php";
            }
        });
    });
});
</script>

<style>
.favorite-btn {
    border: none;
    background: none;
    font-size: 1.5rem;
    color: red;
}
.card-img-top {
    border-radius: 0.5rem 0.5rem 0 0;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.card:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}
</style>

<div class="container mt-5">
    <h1><img src="logo2.png" style="height:50px; width:50px;"> CLOTHIQ</h1>

    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel" align="center">
        <div class="carousel-indicators">
            <?php for ($i = 0; $i < 7; $i++) echo '<button type="button" data-bs-target="#demo" data-bs-slide-to="'.$i.'"'.($i === 0 ? ' class="active"' : '').'></button>'; ?>
        </div>
        <div class="carousel-inner">
            <?php 
            $images = ['demo1.png','demo2.webp','demo3.webp','demo4.jpg','demo5.jpg','demo6.jpg','demo7.webp'];
            $captions = ['Cloths for Family','Cloths for Couples','Cloths for Girls','Cloths for Boys','Cloths for Woman','Cloths for Man','Cloths for Girls'];
            foreach ($images as $i => $img) {
                echo '
                <div class="carousel-item'.($i == 0 ? ' active' : '').'">
                    <img src="photo/'.$img.'" class="d-block" style="height: 600px; width: 80%;">
                    <div class="carousel-caption"><h3>Traditional</h3><p>'.$captions[$i].'</p></div>
                </div>';
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
    </div>

    <!-- Products -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-4">
        <?php
        $products = $con->query("SELECT * FROM items");
        while ($row = $products->fetch_assoc()) {
            $favIcon = in_array($row['id'], $fav_items) ? '❤️' : '🤍';

            echo '<div class="col">
                <div class="card h-100">
                    <img src="' . $row['image'] . '" class="card-img-top" style="height:300px; object-fit:contain;">
                    <div class="card-body d-flex flex-column">
                        <h5>' . $row['name'] . '</h5>
                        <p><strong>Category:</strong> ' . $row['category'] . '</p>
                        <p><strong>Description:</strong> ' . $row['description'] . '</p>
                        <p><strong>Price:</strong> ₹' . $row['price'] . '</p>';

            if (!isset($_SESSION["email"])) {
                echo '<a href="login.php" class="btn btn-outline-dark w-100">Login to Favorite</a>';
            } else {
                echo '
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between mb-2">
                            <a href="payment.php" class="btn btn-outline-dark w-100 me-1">Buy</a>
                            <form action="cart.php" method="POST" class="w-100 ms-1">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-outline-dark w-100">Add to Cart</button>
                            </form>
                        </div>  
                        <button class="btn favorite-btn w-100" name="favorite-btn" data-id="' . $row['id'] . '">' . $favIcon . '</button>
                    </div>';
            }
            echo '</div></div></div>';
        }
        ?>
    </div>
</div>

<?php include 'footar.php'; ?>
