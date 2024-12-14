<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreTrack</title>
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
            padding: 15px 20px;
            background: #007bff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            position: fixed;
        }

        header .app-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        header .app-title i {
            font-size: 20px;
            cursor: pointer;
        }

        .icons-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns */
            gap: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .icons-row.second-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three inline items */
            gap: 10px;
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }

        .icons-row div {
            font-size: 16px;
        }

        .icons-row div span {
            color: white;
            font-size: 14px;
        }

        main {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
            height: 600px; /* Set a fixed height */
            overflow-y: auto; /* Enable vertical scrolling */
            padding: 0px;
        }
        main {
            margin-top: 130px; /* Match the header height */
            padding: 10px; /* Add some padding for aesthetics */
        }


        .product-cost {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap:10px;
            margin-top: 20px;
        }

        .card {
    padding: 50px;
    background: #fff;
    margin-left: 0px;
    margin-right:0px;
    margin-bottom: 5px; /* Add this */
    color: #333;
    border-radius: 8px;
    text-align: left;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}


        .card span {
            font-weight: bold;
        }

        /* Responsive Adjustments */
        @media (max-width: 480px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            .app-title {
                font-size: 18px;
            }

            .icons-row div span {
                font-size: 12px;
            }

            .card-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
        .delete-all-button {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-all-button:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
<header style="width: 100%; padding: 15px 20px; background: #007bff; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
        <!-- Back Button and App Title -->
        <div class="app-title">
            <a href="home.php" style='color:white;'><i class="fas fa-arrow-left"></i></a>
            <span><p>INVENTORY STATUS</p></span>
        </div>

        <!-- First section with 2 items -->
        <div class="icons-row">
            <div>
                <a href="product_available.php" style='text-decoration:none;'>   <span>Available Products</span></a>
            </div>
            <div>
                <a href="expired_product.php"style='text-decoration:none;' ><span>Expired Products</span></a>
            </div>
        </div>

        <!-- Second section with 3 items -->
        <div class="icons-row second-section">
            <div>
                <a href="product_cost.php" style='text-decoration:none;' > <span style=" font-size: 14px; font-weight: bold;">Product Cost</span></a>
            </div>
            <div>
                <a href="product_sold.php"  style='text-decoration:none;'><span >Products Sold</span></a>
            </div>
            <div>
                <a href="encome.php" style='text-decoration:none;' ><span>Incomes</span></a>
            </div>
        </div>
    </header>

    <main>
        <!-- Delete All Button -->
        <form method="POST" style="text-align: center;">
            <button type="submit" name="delete_all" class="delete-all-button">Delete All Products</button>
        </form>

        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "storedb");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle Delete All Products button click
        if (isset($_POST['delete_all'])) {
            $deleteQuery = "DELETE FROM product_name"; // Adjust table name if necessary
            if ($conn->query($deleteQuery) === TRUE) {
                echo "<p style='color: green; text-align: center;'>All products deleted successfully.</p>";
            } else {
                echo "<p style='color: red; text-align: center;'>Error deleting products: " . $conn->error . "</p>";
            }
        }

        // Fetch and display products
        $sql = "SELECT 
            pn.product_name,
            s.size,
            w.weight,
            pi.image_path,
            pe.expiry,
            pn.cost_price,
            sp.selling_price,
            qs.quantity,
            ps.sold_quantity,
            ps.total_price
        FROM 
            product_name pn
        LEFT JOIN size_tbl s ON pn.product_id = s.product_id
        LEFT JOIN weight_tbl w ON pn.product_id = w.product_id
        LEFT JOIN image_product pi ON pn.product_id = pi.product_id
        LEFT JOIN selling_price sp ON pn.product_id = sp.product_id
        LEFT JOIN quantity_tbl qs ON pn.product_id = qs.product_id
        LEFT JOIN product_sold ps ON pn.product_id = ps.product_id
        LEFT JOIN date_expired pe ON pn.product_id = pe.product_id
        WHERE 
            pn.product_id > 0";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card" style="display: flex; flex-direction: row; align-items: flex-start; gap: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff;">
                <img src="./product_img/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image" style="width: 100px; height: 100px; border-radius: 5px; object-fit: cover;">
                <div style="flex: 1;">
                    <div style="font-size: 11px;">Product: <?php echo htmlspecialchars($row['product_name']); ?></div>
                    <div style="font-size: 11px; margin-top: 5px;">Size: <?php echo htmlspecialchars($row['size']); ?></div>
                    <div style="font-size: 11px; margin-top: 5px;">Weight: <?php echo htmlspecialchars($row['weight']); ?></div>
                    <div style="font-size: 11px; margin-top: 5px;">Date: <?php echo htmlspecialchars($row['expiry']); ?></div>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px;">Rate Cost Price: <?php echo htmlspecialchars($row['cost_price']); ?></div>
                    <div style="font-size: 11px;">Selling Price: <?php echo htmlspecialchars($row['selling_price']); ?></div>
                    <div style="font-size: 11px; margin-top: 5px;">Quantity: <?php echo htmlspecialchars($row['sold_quantity']); ?></div>
                    <div style="font-size: 11px; margin-top: 5px;">Total Price: <?php echo htmlspecialchars($row['total_price']); ?></div>
                </div>
            </div>
        <?php
        }
        ?>
    </main>
</body>
</html>
