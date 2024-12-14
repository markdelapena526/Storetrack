from flask import Flask, jsonify
from flask_cors import CORS
import mysql.connector
from sklearn.tree import DecisionTreeClassifier
import numpy as np

app = Flask(__name__)
CORS(app)

# Database connection
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # Add your MySQL password if needed
        database="storedb"
    )

# Train a Decision Tree Classifier
def train_decision_tree():
    # Sample training data
    # Features: [sold_quantity, profit_margin]
    # Labels: ["Best to Sell?" (1 for Yes, 0 for No)]
    X_train = np.array([
        [200, 10],  # High demand, high profit
        [150, 5],   # High demand, moderate profit
        [50, 8],    # Medium demand, high profit
        [20, 2],    # Low demand, low profit
        [100, 1],   # Medium demand, low profit
    ])
    y_train = np.array([1, 1, 1, 0, 0])  # Corresponding labels

    # Train the classifier
    clf = DecisionTreeClassifier()
    clf.fit(X_train, y_train)

    return clf

# Load trained model
decision_tree_model = train_decision_tree()

@app.route('/suggest', methods=['GET'])
def suggest_products():
    try:
        connection = get_db_connection()
        cursor = connection.cursor(dictionary=True)

        # Query product data
        query = """
        SELECT 
            pn.product_id,
            pn.product_name,
            ps.sold_quantity,
            sp.selling_price,
            pn.cost_price,
            (sp.selling_price - pn.cost_price) AS profit_margin,
            de.expiry
        FROM 
            product_name pn
        LEFT JOIN product_sold ps ON pn.product_id = ps.product_id
        LEFT JOIN selling_price sp ON pn.product_id = sp.product_id
        LEFT JOIN Date_expired de ON pn.product_id = de.product_id;
        """
        cursor.execute(query)
        results = cursor.fetchall()

        best_products = []
        for row in results:
            # Handle missing data gracefully
            sold_quantity = row.get('sold_quantity') or 0
            profit_margin = row.get('profit_margin') or 0

            # Prepare feature data for prediction
            feature = np.array([[sold_quantity, profit_margin]])
            
            # Predict using decision tree
            prediction = decision_tree_model.predict(feature)[0]
            best_to_sell = "Yes" if prediction == 1 else "No"

            if best_to_sell == "Yes":
                # Determine demand level
                if sold_quantity >= 150:
                    demand_level = "High"
                elif sold_quantity >= 50:
                    demand_level = "Medium"
                else:
                    demand_level = "Low"

                # Append to best products
                best_products.append({
                    "product_name": row['product_name'],
                    "quantity_sold": sold_quantity,
                    "profit_margin": profit_margin,
                    "expiry_date": row.get('expiry'),
                    "demand_level": demand_level,
                    "best_to_sell": best_to_sell
                })

        return jsonify({"best_products": best_products})
    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        # Ensure database connection is closed
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()


if __name__ == '__main__':
    app.run(debug=True)
