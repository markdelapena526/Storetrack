<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* You can add styles here */
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

        a {
            text-decoration: none;
        }

        header {
            position: fixed;
            width: 100%;
            padding: 20px;
            background: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        header .app-name {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        header .icons-row {
            display: flex;
            gap: 40px;
            margin-top: 20px;
        }

        header .icons-row div {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
        }

        header .icons-row div i {
            font-size: 20px;
            margin-bottom: 8px;
        }
                .search-container {
            position:fixed;
            width: 95%;
            max-width: 500px;
            margin-top: 167px;
        }

        #searchBar {
            width: 100%;
            padding: 10px 40px 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 20px;
            outline: none;
            color: #333;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #333;
            pointer-events: none;
        }

        main {
            margin-top: 210px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            width: 100%;
        }

        .card {
            flex: 1 1 calc(36.33% - 20px);
            max-width: calc(36.33% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0px;
            margin-top:2px;
        }

        .card img {
            width: 90px;
            height: 90px;
            border-radius: 5px;
            object-fit: cover;
        }

        .card div {
            font-size: 8px;
            text-align: center;
        }

        .card .actions {
            display: flex;
            flex-direction: row;
            gap: 10px;
            justify-content: center;
        }

        /* Fixed Circular Card */
        .fixed-circle {
            position: fixed;
            top: 50%;
            left: 0px;
            width: 50px;
            height: 50px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .fixed-circle i {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search products..." />
        <i class="fas fa-search search-icon"></i>
    </div>
    <!-- Fixed Circle -->
    <div class="fixed-circle">
        <a href="counter.php" style="color:white;"><i class="fas fa-cash-register"></i></a>
        <span id="counter-icon" style="color:#ff0000;">
            <?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "storedb");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the number of items in the counter table
            $counter_query = "SELECT COUNT(*) AS counter_count FROM counter";
            $counter_result = $conn->query($counter_query);
            $counter_row = $counter_result->fetch_assoc();
            $counter_value = $counter_row['counter_count'];

            echo $counter_value; // Display the counter value
            $conn->close();
            ?>
        </span>
    </div>

    <main>
    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "storedb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch products where quantity and weight >= 0
    $query = "
        SELECT 
            pn.product_name, 
            st.size, 
            wt.weight, 
            sp.selling_price, 
            ip.image_path, 
            pn.product_id
        FROM product_name pn
        LEFT JOIN size_tbl st ON pn.product_id = st.product_id
        LEFT JOIN weight_tbl wt ON pn.product_id = wt.product_id
        LEFT JOIN selling_price sp ON pn.product_id = sp.product_id
        LEFT JOIN image_product ip ON pn.product_id = ip.product_id
        WHERE COALESCE(st.size, 0) < 1 AND COALESCE(wt.weight, 0) >= 0;
    ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card" data-id="<?php echo htmlspecialchars($row['product_id']); ?>"
                 data-price="<?php echo htmlspecialchars($row['selling_price']); ?>"
                 data-size="<?php echo htmlspecialchars($row['size']); ?>"
                 data-weight="<?php echo htmlspecialchars($row['weight']); ?>"
                 data-name="<?php echo htmlspecialchars($row['product_name']); ?>"> <!-- Add data-name attribute -->
                <img src="./product_img/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image">
                <div>
                    <div>Product: <?php echo htmlspecialchars($row['product_name']); ?></div>
               </div>
                <div>
                    <div>Price:₱ <?php echo htmlspecialchars($row['selling_price']); ?></div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>add more Product</p>";
    }

    $conn->close();
    ?>

    </main>

    <script>
        // Handle the card click to add or remove from the counter
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const productId = card.getAttribute('data-id');
                const price = card.getAttribute('data-price');
                const size = card.getAttribute('data-size');
                const weight = card.getAttribute('data-weight');

                // Increment or decrement the counter value on the page
                const counterIcon = document.getElementById('counter-icon');
                let currentCount = parseInt(counterIcon.textContent);
                currentCount++;
                counterIcon.textContent = currentCount;

                // Send product details to the server
                fetch('add_to_counter.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ productId, price, size, weight }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Product added to counter');
                    } else {
                        console.error('Failed to add product to counter');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Search functionality
        document.getElementById('searchBar').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                const productName = card.dataset.name.toLowerCase(); // Access the product name from data-name
                if (productName.includes(filter)) {
                    card.style.display = 'block'; // Show the card
                } else {
                    card.style.display = 'none'; // Hide the card
                }
            });
        });
    </script>
</body>
</html>
