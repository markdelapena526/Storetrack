<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #bcdffc;
        }
        h1 {
            font-size: 1.5em;
            text-align: center;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 12px;
            color: #fff;
            display: flex;
            align-items: center;
        }
        .card-header i {
            margin-right: 10px;
        }
        .highest-demand {
            background-color: #2196F3; /* Light Blue */
        }
        .medium-demand {
            background-color: #1E88E5; /* Blue */
        }
        .low-demand {
            background-color: #0D47A1; /* Dark Blue */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
        }
        th, td {
            border: none;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        td {
            background-color: #f9f9f9;
        }
        tr:hover td {
            background-color: #f1f1f1;
        }
        .no-products {
            text-align: center;
            color: #777;
            font-style: italic;
        }
        /* Responsive styles */
        @media (max-width: 375px) { /* iPhone SE size */
            body {
                margin: 10px;
            }
            h1 {
                font-size: 1.2em;
            }
            .card {
                padding: 12px;
            }
            .card-header {
                font-size: 1.2em;
            }
            table th, table td {
                padding: 6px;
                font-size: 0.9em;
            }
            button {
                width: 100%;
                padding: 10px;
                font-size: 1.2em;
            }
        }

        /* Scrollable wrapper */
        .scrollable-table-wrapper {
            max-height: 100px; /* Set a fixed height */
            overflow-y: auto; /* Enables vertical scrolling */
        }
    </style>
    <script>
        async function fetchBestProducts() {
            try {
                const response = await fetch('http://127.0.0.1:5000/suggest');
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                const data = await response.json();
                if (data.error) {
                    document.getElementById('error-message').innerText = `Error: ${data.error}`;
                    return;
                }

                // Clear previous tables
                ['highest', 'medium', 'low'].forEach(level => {
                    document.getElementById(`${level}-demand-body`).innerHTML = '';
                });

                if (Array.isArray(data.best_products) && data.best_products.length > 0) {
                    data.best_products.forEach(product => {
                        const row = ` 
                            <tr>
                                <td>${product.product_name}</td>
                                <td>${product.quantity_sold}</td>
                                <td>${product.profit_margin}</td>
                                <td>${product.best_to_sell}</td>
                            </tr>
                        `;
                        const demandLevel = product.demand_level.toLowerCase();
                        if (['highest', 'medium', 'low'].includes(demandLevel)) {
                            document.getElementById(`${demandLevel}-demand-body`).innerHTML += row;
                        }
                    });

                    // Make tables scrollable if there are more than 4 products
                    ['highest', 'medium', 'low'].forEach(level => {
                        const tableBody = document.getElementById(`${level}-demand-body`);
                        if (tableBody.children.length > 4) {
                            document.getElementById(`${level}-demand-table-wrapper`).classList.add('scrollable-table-wrapper');
                        }
                        // Check and show "No products" message if a table is empty
                        if (!tableBody.innerHTML.trim()) {
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="5" class="no-products">No products available</td>
                                </tr>
                            `;
                        }
                    });
                } else {
                    document.getElementById('error-message').innerText = "No best products found.";
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('error-message').innerText = 
                    "Failed to fetch product suggestions.";
            }
        }

        // Automatically fetch the best products when the page loads
        window.onload = fetchBestProducts;
    </script>
</head>
<body>
<i class="fas fa-arrow-left back-icon" onclick="window.history.back();"></i> <!-- Back Icon -->
           
    <h1>StoreTrack - Best Products Suggestion</h1>
    <p id="error-message" style="color: red;"></p>
    <!-- Card for Highest Demand -->
    <div class="card highest-demand">
        <div class="card-header">
            <i class="fas fa-thumbs-up"></i> Highest Demand
        </div>
        <div id="highest-demand-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Profit Margin</th>
                        <th>Best to Sell?</th>
                    </tr>
                </thead>
                <tbody id="highest-demand-body">
                    <!-- Highest demand products will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card for Medium Demand -->
    <div class="card medium-demand">
        <div class="card-header">
            <i class="fas fa-exclamation-triangle"></i> Medium Demand
        </div>
        <div id="medium-demand-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Profit Margin</th>
                        <th>Best to Sell?</th>
                    </tr>
                </thead>
                <tbody id="medium-demand-body">
                    <!-- Medium demand products will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card for Low Demand -->
    <div class="card low-demand">
        <div class="card-header">
            <i class="fas fa-thumbs-down"></i> Low Demand
        </div>
        <div id="low-demand-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Profit Margin</th>
                        <th>Best to Sell?</th>
                    </tr>
                </thead>
                <tbody id="low-demand-body">
                    <!-- Low demand products will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
