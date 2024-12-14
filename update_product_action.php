<?php
// Update product quantity and weight
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $weight = $_POST['weight'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "storedb");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the product in the counter table
    $updateQuery = "UPDATE counter SET quantity = ?, weight = ? WHERE product_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("dii", $quantity, $weight, $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to the main page after update
        header("Location:counter.php");
    } else {
        echo "Failed to update the product.";
    }

    $stmt->close();
    $conn->close();
}
?>
