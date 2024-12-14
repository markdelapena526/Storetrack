<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "storedb");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => $conn->connect_error]));
}

// Query to get the count
$query = "SELECT COUNT(*) as product_count FROM counter";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'count' => $row['product_count']]);
} else {
    echo json_encode(['success' => true, 'count' => 0]);
}

$conn->close();
?>
