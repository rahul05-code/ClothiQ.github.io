<?php
include 'config.php';

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? trim($_GET['category']) : '';

$searchQuery = "SELECT * FROM items WHERE 1";

$params = [];
$types = "";

if (!empty($searchTerm)) {
    $searchQuery .= " AND name LIKE ?";
    $params[] = "%{$searchTerm}%";
    $types .= "s";
}

if (!empty($categoryFilter)) {
    $searchQuery .= " AND category = ?";
    $params[] = $categoryFilter;
    $types .= "s";
}

$stmt = $con->prepare($searchQuery);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>" style="height: 300px; object-fit: contain; background-color: #f8f8f8;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                    <p class="card-text">₹<?php echo htmlspecialchars($item['price']); ?></p>
                    <a href="payment.php?id=<?php echo $item['id']; ?>" class="btn btn-dark">View Details</a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p class='col-12'>No products found.</p>";
}
?>
<style>
    .card-img-top {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.card:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

</style>
