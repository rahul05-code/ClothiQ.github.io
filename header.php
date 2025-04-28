<?php 
session_start();
include 'config.php';

if (isset($_SESSION['email']) && $_SESSION['email'] != 'unset') {
    $email = $_SESSION['email'];

    $query = "SELECT * FROM edituser WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $profile_pic = $user['profile_pic'] ?? 'default.png'; // fallback to default if null
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="logo2.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            margin-top: 70px;
        }
        .content {
            padding: 80px 20px 20px;
            text-align: left;
        }
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .profile-container {
            text-align: center;
        }
        .profile-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['email']) || $_SESSION['email'] == 'unset'): ?>
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Payment</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Favorites</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login/Register</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="payment.php">Payment</a></li>
                        <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="favorites.php">Favorites</a></li>
                    <?php endif; ?>
                </ul>
                <?php if (isset($_SESSION['email']) && $_SESSION['email'] != 'unset'): ?>
    <!-- Profile Avatar Dropdown -->
    <div class="nav-item dropdown ms-auto">
        <a class="nav-link dropdown-toggle d-flex align-items-center bg-dark" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="profile-avatar">
                <img src="photo/uploads/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile" width="40" height="40" style="border-radius:50%;">
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="dashbord.php">Edit Profile</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </div>
<?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Add Bootstrap JS for the collapsing functionality -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
