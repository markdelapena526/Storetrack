<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         /* Styling for the pop-up */
         body {
             background: linear-gradient(135deg, #1e90ff, #87ceeb);
           }
         .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            width: 100%;
        }

        .popup-content input {
            margin-bottom: 10px;
            padding: 5px;
            width: 100%;
        }
          /* Fixed header styling */
          #header-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #0066cc; /* Blue family background color */
            color: white;
            padding: 10px 0;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #header-container a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        #header-container h1 {
            margin: 0;
        }

        #header-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #header-container button:hover {
            opacity: 0.9;
        }

        #header-container button:first-of-type {
            background-color: #ff4d4d;
            color: white;
        }

        #header-container button:last-of-type {
            background-color: #4caf50;
            color: white;
        }
        main {
            margin-top: 130px; /* Adjust this value to the height of the header */
        }
    </style>
</head>
<body>
<div id="header-container" style="text-align: center; margin-bottom: 20px;">
  <!-- Back icon and Counter header -->
  <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-top:10px;">
  <a href="home.php" style='color:black;'><i class="fas fa-arrow-left"></i></a>
    
  <h1 style="margin: 0;">Counter</h1>       
</div>

  <!-- Buttons -->
  <div style="margin-top: 20px; display: flex; justify-content: center; gap: 15px;">

    <!-- Existing buttons -->

 <form method="POST" style="display: inline;">
 <button type="submit" name="cancel">Cancel</button>
      <button type="submit" name="pay" style="padding: 10px 20px; background: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer;">Pay</button>
    </form>
 </div>
</div>

<main>
<?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "storedb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle the Cancel button click
if (isset($_POST['cancel'])) {
    try {
        // Clear the counter table
        $clearQuery = "DELETE FROM counter";
        if ($conn->query($clearQuery)) {
             echo'<script>window.location.href="home.php"</script>';
              } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
     }
}

  // Handle the Pay button click
if (isset($_POST['pay'])) {
    $conn->begin_transaction(); // Start transaction
    try {
        // Insert data into product_sold with correct total_price calculation
        $insertQuery = "
            INSERT INTO product_sold (sold_id, sold_quantity, weight, date, time, total_price, product_id)
            SELECT 
                NULL, 
                quantity, 
                weight, 
                CURDATE(), 
                CURTIME(), 
                price * IFNULL(quantity, weight), -- Correct total_price calculation
                product_id 
            FROM counter
        ";
        if (!$conn->query($insertQuery)) {
            throw new Exception($conn->error);
        }

        // Deduct quantities from quantity_tbl
        $deductQuery = "
            UPDATE quantity_tbl qt
            JOIN counter c ON qt.product_id = c.product_id
            SET qt.quantity = qt.quantity - c.quantity
            WHERE qt.quantity >= c.quantity
        ";
        if (!$conn->query($deductQuery)) {
            throw new Exception($conn->error);
        }

        // Deduct weights from weight_tbl
        $deductWeightQuery = "
            UPDATE weight_tbl wt
            JOIN counter c ON wt.product_id = c.product_id
            SET wt.total_weight = wt.total_weight - c.weight
            WHERE wt.total_weight >= c.weight
        ";
        if (!$conn->query($deductWeightQuery)) {
            throw new Exception($conn->error);
        }

        // Clear the counter table
        if (!$conn->query("DELETE FROM counter")) {
            throw new Exception($conn->error);
        }

        $conn->commit(); // Commit transaction
        echo "<p style='color: green; text-align: center;'>Payment successful</p>";
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction
        echo "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
    }
}


    // Initialize the grand total variable
    $grandTotal = 0;

    // Fetch data from counter table with product details
    $query = "
        SELECT c.product_id, pn.product_name, c.size, c.weight, c.price, c.quantity, 
               (c.price * IFNULL(c.quantity, 0)) AS total_price, ip.image_path
        FROM counter c
        JOIN product_name pn ON c.product_id = pn.product_id
        LEFT JOIN image_product ip ON c.product_id = ip.product_id
    ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $price = is_numeric($row['price']) ? $row['price'] : 0;
            $quantity = is_numeric($row['quantity']) ? $row['quantity'] : 0;
            $weight = is_numeric($row['weight']) ? $row['weight'] : 0;
            $totalPrice = $price * $quantity * $weight;
            $grandTotal += $totalPrice;
            ?>
            <div class="card" style="display: flex; flex-direction: row; align-items: flex-start; gap: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff;">
                <!-- Product Image -->
                <img src="product_img/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image" style="width: 70px; height: 70px; border-radius: 5px; object-fit: cover;">
                
                <!-- Product Details -->
                <div style="flex: 1;">
                    <div style="font-weight: none; font-size:11px;">Product: <?php echo htmlspecialchars($row['product_name']); ?></div>
                    <div style="font-weight: none; font-size:11px; margin-top: 5px;">Size: <?php echo htmlspecialchars($row['size']); ?></div>
                 </div>
                
                <!-- Price Details -->
                <div style="flex: 1;">
                    <div style="font-weight: none; font-size:11px;">Price: <?php echo htmlspecialchars($price); ?></div>
                   <div style="font-weight: none; font-size:11px; margin-top: 5px;">Total Price: <?php echo htmlspecialchars($totalPrice); ?></div>
                </div>

                <!-- Action Icons (Update and Delete) -->
                <div style="flex: 1; display: flex; flex-direction: column; gap: 30px; align-items: flex-end;">
                    <!-- Update Button -->
                    <a href="#" onclick="showUpdatePopup(<?php echo $row['product_id']; ?>, '<?php echo $row['product_name']; ?>', <?php echo $row['quantity']; ?>, <?php echo $row['weight']; ?>);" style="font-size: 20px; color: #28a745; text-decoration: none;">
                        <i class="fas fa-edit" style="margin-right: 2px;"></i>
                    </a>
                    <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" style="font-size: 30px; color: #dc3545; text-decoration: none; display: flex; align-items: center;">
                        <i class="fas fa-times" style="margin-right: 5px; font-size:25px;"></i>
                    </a>
                </div>
            </div>
            <?php
        }
    } else {
   }

    $conn->close();
    ?>
    <!-- Grand Total display -->
  <div style="margin-top: 10px; font-size: 20px; font-weight: bold; margin-bottom:50px;">
    Grand Total: <span id="grand-total"><?php echo number_format($grandTotal, 2); ?></span>
  </div>
  <!-- Pop-up for Update -->
  <div class="popup" id="update-popup">
        <div class="popup-content">
            <h3>Update Product</h3>
            <form id="update-form" method="post" action="update_product_action.php">
                <input type="hidden" name="product_id" id="update-product-id">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="update-quantity" >
                <label for="weight">Weight</label>
                <input type="number" name="weight" id="update-weight" >
                <button type="submit" style="padding: 10px; background-color: #4caf50; color: white; border: none; border-radius: 5px;">Update</button>
                <button type="button" onclick="closePopup()" style="padding: 10px; background-color: #ff4d4d; color: white; border: none; border-radius: 5px;">Close</button>
            </form>
        </div>
    </div>

</main>

<script>
// Function to show the update pop-up with product data
function showUpdatePopup(id, name, quantity, weight) {
    document.getElementById("update-product-id").value = id;
    document.getElementById("update-quantity").value = quantity;
    document.getElementById("update-weight").value = weight;
    document.getElementById("update-popup").style.display = "flex";
}

// Function to close the update pop-up
function closePopup() {
    document.getElementById("update-popup").style.display = "none";
}
</script>
</body>
</html>