<?php
$conn = new mysqli("localhost", "root", "", "project1");
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed"]);
    exit();
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add_item':
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $image_path = '';
        if (isset($_FILES['image'])) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_path = 'photo/items/' . basename($image_name);
            move_uploaded_file($image_tmp, $image_path);
        }

        $stmt = $conn->prepare("INSERT INTO items (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $description, $price, $image_path, $category);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Item added successfully!"]);
        break;

    case 'delete_user':
        $id = $_POST['user_id'];
        $conn->query("DELETE FROM users WHERE id=$id");
        echo json_encode(["status" => "success", "message" => "User deleted"]);
        break;

    case 'delete_item':
        $id = $_POST['item_id'];
        $conn->query("DELETE FROM items WHERE id=$id");
        echo json_encode(["status" => "success", "message" => "Item deleted"]);
        break;

    // More actions like update_item, delete_message, etc.
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}

$conn->close();
?>
