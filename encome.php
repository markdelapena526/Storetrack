<?php
// Assuming you have already connected to the database
  // Database connection
  $conn = new mysqli("localhost", "root", "", "storedb");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

// Query to fetch the sold products with their details (quantity sold, date, and product_id)
$query = "
    SELECT ps.sold_quantity, ps.date, ps.product_id, sp.selling_price, pn.cost_price
    FROM product_sold ps
    JOIN selling_price sp ON ps.product_id = sp.product_id
    JOIN product_name pn ON ps.product_id = pn.product_id
";

// Execute query
$result = mysqli_query($conn, $query);

// Initialize variables to store net income calculations for each period
$daily_income = 0;
$weekly_income = 0;
$monthly_income = 0;
$yearly_income = 0;
$current_date = date('Y-m-d');

// Iterate through the results and calculate the net income for each product sold
while ($row = mysqli_fetch_assoc($result)) {
    $quantity_sold = $row['sold_quantity'];
    $selling_price = $row['selling_price'];
    $cost_price = $row['cost_price'];
    $net_income = ($selling_price - $cost_price) * $quantity_sold;
    $sold_date = $row['date'];

    // Convert the sold date to DateTime object
    $sold_date_obj = new DateTime($sold_date);
    $current_date_obj = new DateTime($current_date);

    // Calculate the difference between the sold date and the current date
    $interval = $sold_date_obj->diff($current_date_obj);

    // Categorize by date (Daily)
    if ($interval->days == 0) {
        $daily_income += $net_income;
    }
    
    // Categorize by week (Weekly - same week number)
    if ($sold_date_obj->format('W') == $current_date_obj->format('W') && $sold_date_obj->format('Y') == $current_date_obj->format('Y')) {
        $weekly_income += $net_income;
    }
    
    // Categorize by month (Monthly - same month)
    if ($sold_date_obj->format('m') == $current_date_obj->format('m') && $sold_date_obj->format('Y') == $current_date_obj->format('Y')) {
        $monthly_income += $net_income;
    }
    
    // Categorize by year (Yearly - same year)
    if ($sold_date_obj->format('Y') == $current_date_obj->format('Y')) {
        $yearly_income += $net_income;
    }
}

?>

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
            padding: 30px;
            background: #fff;
            margin-left:5px;
            margin-right: 5px;
            color: #333;
            border-radius: 8px;
            text-align:left;
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
                <a href="product_cost.php" style='text-decoration:none;' > <span>Product Cost</span></a>
            </div>
            <div>
                <a href="product_sold.php"  style='text-decoration:none;'><span>Products Sold</span></a>
            </div>
            <div>
                <a href="encome.php" style='text-decoration:none;' ><span style=" font-size: 14px; font-weight: bold;">Incomes</span></a>
            </div>
        </div>
    </header>
    <main>
        <div class="product-cost">Net income : ₱<?php echo number_format($daily_income, 2); ?>
        </div>
        <hr>
        <div class="card-container">
        <?php if ($daily_income > 0): ?>
        <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-weight: bold;"><?php echo date('M d, Y'); ?></div>
        </div>
        <div style="font-size: 18px; font-weight: bold; margin-left: auto;">
        ₱<?php echo number_format($daily_income, 2); ?>
        </div>
              </div>
              <?php endif; ?>
           
              </div>
        </div>
    </main>
</body>
</html>
