<?php
// Connect to the database
$host = "localhost"; 
$username = "root";
$password = "";
$dbname = "project1"; 

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";


// Handle the form submission for inserting an item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category']; // Get category from the form

    // Handle the file upload
    if (isset($_FILES['image'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];

        // Validate image file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 5000000; // Max size: 5MB

        if (in_array($image_type, $allowed_types) && $image_size <= $max_size) {
            $image_upload_dir = 'photo/items/';
            $image_path = $image_upload_dir . basename($image_name);

            // Move the uploaded file to the server's folder
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Insert item into the database including the category
                $sql = "INSERT INTO items (name, description, price, image, category) 
                        VALUES ('$name', '$description', '$price', '$image_path', '$category')";

                if ($conn->query($sql) === TRUE) {
                    $message = "<div class='alert success'>✅ New item added successfully!</div>";
                } else {
                    $message = "<div class='alert error'>❌ Error adding item: " . $conn->error . "</div>";
                }

            } else {
                $message = "<div class='alert error'>❌ Error uploading the image!</div>";
            }
        } else {
            $message = "<div class='alert error'>❌ Invalid image type or file size exceeds 5MB.</div>";
        }
    }
}

// Handle item update
if (isset($_POST['update_item'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Update the item in the database
    $sql = "UPDATE items SET name='$name', description='$description', price='$price', category='$category' WHERE id=$item_id";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert success'>✅ Item updated successfully!</div>";
    } else {
        $message = "<div class='alert error'>❌ Error updating item: " . $conn->error . "</div>";
    }
    
    
}

// Handle item deletion
if (isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id'];

    // Check if item exists in the cart
    $check_cart_sql = "SELECT * FROM cart WHERE item_id = $item_id";
    $cart_result = $conn->query($check_cart_sql);

    if ($cart_result && $cart_result->num_rows > 0) {
        $message = "<div class='alert error'>❌ Cannot delete: This item is in someone's cart.</div>";
    } else {
        // Safe to delete
        $sql = "DELETE FROM items WHERE id = $item_id";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert success'>✅ Item deleted successfully!</div>";
        } else {
            $message = "<div class='alert error'>❌ Error deleting item: " . $conn->error . "</div>";
        }
    }
}


// Fetch all items from the database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

// Fetch all users from the database
$sql_users = "SELECT id, name, email FROM users";
$result_users = $conn->query($sql_users);

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert success'>✅ User deleted successfully!</div>";
    } else {
        $message = "<div class='alert error'>❌ Error deleting user: " . $conn->error . "</div>";
    }
    
    
}


// Fetch a single item for updating (if ID is passed)
$item_for_update = null;
if (isset($_GET['update_id'])) {
    $item_id = $_GET['update_id'];
    $sql = "SELECT * FROM items WHERE id = $item_id";
    $result_for_update = $conn->query($sql);
    $item_for_update = $result_for_update->fetch_assoc();
}
?>

<?php
// Fetch all messages from the contact_messages table
$sql_messages = "SELECT * FROM contact_messages ORDER BY id DESC";
$result_messages = $conn->query($sql_messages);

// Handle message deletion
if (isset($_POST['delete_message'])) {
    $message_id = $_POST['message_id'];

    // Delete the message from the database
    $sql_delete = "DELETE FROM contact_messages WHERE id = $message_id";

    if ($conn->query($sql_delete) === TRUE) {
        $message = "<div class='alert success'>✅ Message deleted successfully!</div>";
    } else {
        $message = "<div class='alert error'>❌ Error deleting message: " . $conn->error . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="logo2.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Items</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
        color: #fff;
        margin: 0;
        padding: 40px 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }

    .container {
        background-color: #1c1c1c;
        padding: 30px;
        border-radius: 12px;
        width: 95%;
        max-width: 1000px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        backdrop-filter: blur(5px);
    }

    h1, h2 {
        text-align: center;
        color: #f1f1f1;
        margin-top: 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 10px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 40px;
    }

    input, select, textarea {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #555;
        background: #2c2c2c;
        color: #fff;
        transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #007BFF;
        outline: none;
    }

    input[type="submit"] {
        background-color: #007BFF;
        color: white;
        border: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #2a2a2a;
        border-radius: 10px;
        overflow: hidden;
    }

    table th, table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #444;
        color: #eee;
    }

    table th {
        background-color: #007BFF;
        color: white;
    }

    img {
        border-radius: 6px;
    }

    input[type="submit"][value="Delete"] {
        background-color: #dc3545;
    }

    input[type="submit"][value="Delete"]:hover {
        background-color: #a71d2a;
    }

    form[method="GET"] input[type="submit"] {
        background-color: #ffc107;
        color: #000;
    }

    form[method="GET"] input[type="submit"]:hover {
        background-color: #e0a800;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        table th, table td {
            font-size: 14px;
        }
    }
    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
    }

    .alert.success {
        background-color: #28a745;
        color: white;
    }

    .alert.error {
        background-color: #dc3545;
        color: white;
    }

</style>
<script src="jquery-3.7.1.min.js"></script>
</head>
<body>

<script>
document.querySelectorAll('form[action="admin.php"][method="POST"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('action', form.querySelector('input[name="delete_user"]') ? 'delete_user' : 'delete_item');

        fetch('admin-actions.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                form.closest('tr').remove(); // remove row from table
            }
        }).catch(err => console.log('Error:', err));
    });
});
</script>


<div class="container">
    <?php if (!empty($message)) echo $message; ?>
    <h1>Admin - Add New Clothing Item</h1>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <label for="name">Item Name:</label>
        <input type="text" id="name" name="name" value="<?= isset($item_for_update) ? $item_for_update['name'] : '' ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= isset($item_for_update) ? $item_for_update['description'] : '' ?></textarea>

        <label for="price">Price (₹):</label>
        <input type="text" id="price" name="price" value="<?= isset($item_for_update) ? $item_for_update['price'] : '' ?>" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="Men" <?= isset($item_for_update) && $item_for_update['category'] == 'Men' ? 'selected' : '' ?>>Men</option>
            <option value="Women" <?= isset($item_for_update) && $item_for_update['category'] == 'Women' ? 'selected' : '' ?>>Women</option>
            <option value="Kids" <?= isset($item_for_update) && $item_for_update['category'] == 'Kids' ? 'selected' : '' ?>>Kids</option>
        </select>

        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image">

        <?php if (isset($item_for_update)): ?>
            <input type="hidden" name="item_id" value="<?= $item_for_update['id'] ?>">
            <input type="submit" name="update_item" value="Update Item">
        <?php else: ?>
            <input type="submit" name="add_item" value="Add Item">
        <?php endif; ?>
    </form>

    <!-- ITEMS TABLE -->
    <h2>Items List</h2>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>₹" . $row['price'] . "</td>
                            <td>" . $row['category'] . "</td>
                            <td><img src='" . $row['image'] . "' alt='Item Image' width='50'></td>
                            <td>
                                <form action='admin.php' method='GET' style='display:inline;'>
                                    <input type='hidden' name='update_id' value='" . $row['id'] . "'>
                                    <input type='submit' value='Edit'>
                                </form>
                                <form action='admin.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                                    <input type='hidden' name='item_id' value='" . $row['id'] . "'>
                                    <input type='submit' name='delete_item' value='Delete' style='background-color: red; color: white;'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No items found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- USERS TABLE -->
    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_users->num_rows > 0) {
                while ($user = $result_users->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $user['id'] . "</td>
                            <td>" . $user['name'] . "</td>
                            <td>" . $user['email'] . "</td>
                            <td>
                                <form action='admin.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure?\")'>
                                    <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                                    <input type='submit' name='delete_user' value='Delete' style='background-color: red; color: white;'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <h2>Contact Messages</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result_messages->num_rows > 0) {
            while ($message = $result_messages->fetch_assoc()) {
                echo "<tr>
                        <td>" . $message['id'] . "</td>
                        <td>" . $message['name'] . "</td>
                        <td>" . $message['email'] . "</td>
                        <td>" . $message['message'] . "</td>
                        <td>
                            <form action='admin.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this message?\")'>
                                <input type='hidden' name='message_id' value='" . $message['id'] . "'>
                                <input type='submit' name='delete_message' value='Delete' style='background-color: red; color: white;'>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No messages found</td></tr>";
        }
        ?>
    </tbody>
</table>

</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>


