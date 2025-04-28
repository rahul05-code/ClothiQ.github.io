<?php
include 'config.php';
include 'header.php';

// Fetch categories from database
$categoryQuery = "SELECT DISTINCT category FROM items";
$categoryResult = $con->query($categoryQuery);

// Search logic
$searchQuery = "";
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? trim($_GET['category']) : '';

if ($searchTerm || $categoryFilter) {
    $searchQuery = "SELECT * FROM items WHERE 1";

    if (!empty($searchTerm)) {
        $searchQuery .= " AND name LIKE ?";
    }

    if (!empty($categoryFilter)) {
        $searchQuery .= " AND category = ?";
    }

    $stmt = $con->prepare($searchQuery);

    if (!empty($searchTerm) && !empty($categoryFilter)) {
        $likeSearch = "%{$searchTerm}%";
        $stmt->bind_param("ss", $likeSearch, $categoryFilter);
    } elseif (!empty($searchTerm)) {
        $likeSearch = "%{$searchTerm}%";
        $stmt->bind_param("s", $likeSearch);
    } elseif (!empty($categoryFilter)) {
        $stmt->bind_param("s", $categoryFilter);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Show all products if no search/filter applied
    $result = $con->query("SELECT * FROM items");
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
<div class="container mt-5">
    <h1>Search Products</h1>

    <!-- Search & Category Filter -->
    <form id="searchForm" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <select name="category" id="categoryFilter" class="form-control">
            <option value="">All Categories</option>
            <?php while ($row = $categoryResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['category']); ?>" <?php if ($row['category'] == $categoryFilter) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['category']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <div class="input-group-append">
            <button class="btn btn-dark" type="submit">
                <i class="glyphicon glyphicon-search"></i> Search
            </button>
        </div>
    </div>
</form>


    
    <!-- Display Products -->
<div class="row" id="productResults">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($item = $result->fetch_assoc()): ?>
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
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-12">No products found.</p>
    <?php endif; ?>
</div>

</div>

<?php include 'footar.php'; ?>

<script src="jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Trigger search on form submit
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // prevent full reload

        let search = $('#searchInput').val();
        let category = $('#categoryFilter').val();

        $.ajax({
            url: 'search_ajax.php',
            type: 'GET',
            data: {
                search: search,
                category: category
            },
            success: function(data) {
                $('#productResults').html(data);
            },
            error: function() {
                $('#productResults').html("<p class='col-12 text-danger'>Something went wrong. Please try again.</p>");
            }
        });
    });

    // Optional: trigger search on typing (live search)
    $('#searchInput, #categoryFilter').on('input change', function () {
        $('#searchForm').submit();
    });
});
</script>

