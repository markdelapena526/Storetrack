<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e90ff, #87ceeb);
            color: #fff;
        }

        .login-form {
            width: 90%;
            max-width: 400px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 12px 12px 40px; /* Adjust padding for the icon */
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 20px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>StoreTrack</h2>
        <form>
            <div class="form-group">
                <i class="fa fa-lock"></i> <!-- Icon inside the input -->
                <input type="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-button">Log In</button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
