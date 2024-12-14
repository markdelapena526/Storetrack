<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'storedb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$query = "
    SELECT 
        pn.product_name,
        ps.sold_quantity,
        sp.selling_price,
        pn.cost_price,
        DATEDIFF(de.expiry, CURDATE()) AS expiry_days
    FROM 
        product_name pn
    LEFT JOIN product_sold ps ON pn.product_id = ps.product_id
    LEFT JOIN selling_price sp ON pn.product_id = sp.product_id
    LEFT JOIN Date_expired de ON pn.product_id = de.product_id;
";

$result = $conn->query($query);
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
