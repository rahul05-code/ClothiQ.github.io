<?php 
session_start();
include 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['email'] == 'unset') {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];

// Fetch current user data
$query = "SELECT * FROM edituser WHERE email = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$existingUser = $user ? true : false;

if (!$user) {
    $user = [
        'name' => '',
        'email' => $email,
        'gender' => '',
        'phone_no' => '',
        'address' => '',
        'created_at' => '',
        'profile_pic' => 'default.png'
    ];
}

$profile_pic = $user['profile_pic'] ?? 'default.png';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $gender = htmlspecialchars($_POST['gender']);
    $phone_no = htmlspecialchars($_POST['phone_no']);
    $address = htmlspecialchars($_POST['address']);

    // File Upload Handling
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "photo/uploads/";
        $file_name = basename($_FILES["profile_pic"]["name"]);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $target_file = $target_dir . time() . "_" . uniqid() . "." . $file_ext;

        $allowed_exts = ["jpg", "jpeg", "png"];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file_ext, $allowed_exts)) {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG allowed.";
            header("Location: dashboard.php");
            exit();
        }

        if ($_FILES["profile_pic"]["size"] > $max_size) {
            $_SESSION['error'] = "File size exceeds 2MB limit.";
            header("Location: dashboard.php");
            exit();
        }

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            if ($profile_pic != 'default.png' && file_exists($profile_pic)) {
                unlink($profile_pic);
            }
            $profile_pic = $target_file;
        } else {
            $_SESSION['error'] = "Error uploading file.";
            header("Location: dashboard.php");
            exit();
        }
    }

    // Insert or Update user data
    if ($existingUser) {
        $updateQuery = "UPDATE edituser SET name=?, gender=?, phone_no=?, address=?, profile_pic=? WHERE email=?";
        $stmt = $con->prepare($updateQuery);
        $stmt->bind_param("ssssss", $name, $gender, $phone_no, $address, $profile_pic, $email);
    } else {
        $insertQuery = "INSERT INTO edituser (name, email, gender, phone_no, address, profile_pic) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("ssssss", $name, $email, $gender, $phone_no, $address, $profile_pic);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }

    header("Location: dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="logo2.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="payment.php">Payment</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="favorites.php">Favorites</a></li>
                </ul>

                <?php if (isset($_SESSION['email']) && $_SESSION['email'] != 'unset'): ?>
                    <!-- Profile Avatar Dropdown -->
                    <div class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle d-flex align-items-center bg-dark" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-avatar">
                                <img src="photo/uploads/<?php echo $profile_pic; ?>" alt="Profile">
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

    <div class="container mt-5">
        <h1 class="mt-4 text-center">User Profile</h1>

        <div class="profile-container">
            <img src="photo/uploads/<?php echo $profile_pic; ?>" alt="Profile Picture">
        </div>

        <form action="editprofile.php" method="POST" enctype="multipart/form-data">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <table class="table table-bordered mt-3">
                <tr>
                    <th>Profile Picture</th>
                    <td>
                        <input type="file" name="profile_pic" class="form-control">
                        <small>Allowed formats: JPG, PNG (Max: 2MB)</small>
                    </td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>
                        <select name="gender" class="form-control">
                            <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><input type="text" name="phone_no" class="form-control" value="<?php echo htmlspecialchars($user['phone_no']); ?>" required></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><textarea name="address" class="form-control" required><?php echo htmlspecialchars($user['address']); ?></textarea></td>
                </tr>
                <tr>
                    <th>Registration Date</th>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                </tr>
            </table>
            
            <button type="submit" class="btn btn-dark">Update Profile</button>
        </form>
    </div>

<?php include 'footar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
