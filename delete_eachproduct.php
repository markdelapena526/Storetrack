<?php
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "storedb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete query
    $sql = "DELETE FROM product_name WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
