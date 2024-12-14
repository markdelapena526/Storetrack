<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "storedb";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST['product-name'];
    $size = !empty($_POST['size']) ? $_POST['size'] : null;
    $quantity = !empty($_POST['quantity']) ? $_POST['quantity'] : null;
    $expiry = !empty($_POST['expiry']) ? $_POST['expiry'] : null;
    $costPrice = $_POST['cost-price'];
    $sellingPrice = $_POST['selling-price'];
    $imagePath = $_FILES['upload']['name'];

    // Upload image to the server
    $targetDir = "product_img/";
    $targetFile = $targetDir . basename($_FILES["upload"]["name"]);
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFile)) {
      
    } else {
        echo "Error uploading image.";
    }

    // Insert data into `product_name` table
    $stmt = $conn->prepare("INSERT INTO product_name (product_name, cost_price) VALUES (?, ?)");
    $stmt->bind_param("si", $productName, $costPrice);
    if ($stmt->execute()) {
        $productId = $stmt->insert_id; // Get the last inserted product_id

        // Insert data into `selling_price` table
        $stmtSelling = $conn->prepare("INSERT INTO selling_price (selling_price, product_id) VALUES (?, ?)");
        $stmtSelling->bind_param("ii", $sellingPrice, $productId);
        $stmtSelling->execute();

        // Insert data into `quantity_tbl` table
        if ($quantity !== null) {
            $stmtQuantity = $conn->prepare("INSERT INTO quantity_tbl (quantity, product_id) VALUES (?, ?)");
            $stmtQuantity->bind_param("ii", $quantity, $productId);
            $stmtQuantity->execute();
        }

           // Insert data into `quantity_cost` table
if ($quantity !== null) {
    $stmtQuantityCost = $conn->prepare("INSERT INTO quantity_cost (quantity, product_id) VALUES (?, ?)");
    $stmtQuantityCost->bind_param("ii", $quantity, $productId); // 'ii' -> integer, integer
    $stmtQuantityCost->execute();
}
          // Insert data into `size_tbl` table
          if ($size !== null) {
            $stmtSize = $conn->prepare("INSERT INTO size_tbl (size, product_id) VALUES (?, ?)");
            $stmtSize->bind_param("si", $size, $productId);
            $stmtSize->execute();
        }

        // Insert data into `date_expired` table
        if ($expiry !== null) {
            $stmtExpiry = $conn->prepare("INSERT INTO date_expired (expiry, product_id) VALUES (?, ?)");
            $stmtExpiry->bind_param("si", $expiry, $productId);
            $stmtExpiry->execute();
        }

        // Insert data into `image_product` table
        $stmtImage = $conn->prepare("INSERT INTO image_product (image_path, product_id) VALUES (?, ?)");
        $stmtImage->bind_param("si", $imagePath, $productId);
        $stmtImage->execute();

        
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e90ff, #87ceeb);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            width: 100%;
            padding: 20px;
            background: #007bff;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        header .app-name {
            font-size: 24px;
            font-weight: bold;
        }

        .product-form {
            width: 90%;
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #333;
            margin-top: 20px;
        }

        .product-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .product-form{
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 2px;
            font-weight: bold;
            font-size: 12px;
            color:#0056b3;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 5px;
            font-size: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .form-group .upload-container {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .form-group .upload-container label {
            font-size: 12px;
            cursor: pointer;
            color: #007bff;
        }

        .form-group input[type="file"] {
            display: none;
        }

        .add-button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>  
    <div class="product-form">
        <h2> <a href="home.php" style='color:#0056b3; margin-right:15px;'><i class="fas fa-arrow-left"></i></a>Product Registration</h2>
        <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
    <label for="category">Select Category</label>
    <select id="category" onchange="navigateToForm()" style="width:200px;">
        <option value="">Product with weight </option>
        <option value="form_weight.php">Product with weight</option>
        <option value="form_without_weight.php">Product without weight</option>
        <option value="form_size.php">Product with size</option>
         <option value="add_product.php">Product without weight & size</option>
    </select>
</div>

<script>
    function navigateToForm() {
        const selectedValue = document.getElementById("category").value;
        if (selectedValue) {
            window.location.href = selectedValue;
        }
    }
</script>

            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name " name='product-name'placeholder="Enter product name" required>
            </div>
            
            <div class="form-group">
                <label for="weight">Product Size</label>
                <input type="text" id="weight" name='size' placeholder="Enter weight in kg">
            </div>
            <div class="form-group">
                <label for="quantity">Product Quantity</label>
                <input type="number" id="quantity" name='quantity' placeholder="Enter quantity">
            </div>
            <div class="form-group">
                <label for="expiry">Expiry Date</label>
                <input type="date" id="expiry" name='expiry' >
            </div>
            <div class="form-group">
                <label for="cost-price">Cost Price</label>
                <input type="number" id="cost-price" name='cost-price' placeholder="Enter cost price">
            </div>
            <div class="form-group">
                <label for="selling-price">Selling Price</label>
                <input type="number" id="selling-price" name='selling-price'  placeholder="Enter selling price">
            </div>
            <div class="form-group">
                    <label for="upload"><i class="fas fa-camera"></i> Upload</label>
                    <input type="file" id="upload" required name='upload'>
            </div>
            <button type="submit" class="add-button">Add Product</button>
        </form>
    </div>
</body>
</html>
