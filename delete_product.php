<?php
// Delete product from counter
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "storedb");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $deleteQuery = "DELETE FROM counter WHERE product_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to the main page after deletion
        header("Location:counter.php");
    } else {
        echo "Failed to delete the product.";
    }

    $stmt->close();
    $conn->close();
}
?>
