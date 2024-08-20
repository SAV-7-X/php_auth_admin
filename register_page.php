<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #ECF0F1;
            --accent-color: #3498DB;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="container">
        <div id="passkeyForm" class="form-container">
            <h2 class="text-2xl font-bold mb-6 text-center">Admin Access</h2>
            <form id="passkeyCheckForm" >
                <input type="password" id="passkey" name="passkey" class="input-field" placeholder="Enter Passkey" required>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
        <div id="registerForm" class="form-container hidden">
            <h2 class="text-2xl font-bold mb-6 text-center">Admin Registration</h2>
            <form id="adminRegisterForm">
                <input type="text" id="username" name="username" class="input-field" placeholder="Username" required>
                <input type="email" id="email" name="email" class="input-field" placeholder="Email" required>
                <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
                <button type="submit" class="submit-btn">Register</button>
            </form>
            <p class="mt-4 text-center">Already have an account? <a href="login_page.php" class="text-blue-500">Login</a></p>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>