<?php
// Get the raw POST data
$data = json_decode(file_get_contents("php://input"));

// Extract product details
$productId = $data->productId;
$price = $data->price;
$size = $data->size;
$weight = $data->weight;

// Database connection
$conn = new mysqli("localhost", "root", "", "storedb");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Insert the product into the counter table
$query = "INSERT INTO counter (product_id, quantity, price, size, weight) VALUES (?, 1,?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("idss", $productId, $price, $size, $weight);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product added to counter"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to add product to counter"]);
}

$stmt->close();
$conn->close();
?>
