<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login_page.php');
    exit;
}

require_once 'db_config.php';

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch all users
$all_users = [];
$result = $conn->query("SELECT id, username, email FROM users");
while ($row = $result->fetch_assoc()) {
    $all_users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .dark {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        .light {
            background-color: #f7fafc;
            color: #2d3748;
        }
        .hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .table-container {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table-row:hover {
            transition: background-color 0.3s ease;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 179, 237, 0.3);
        }
    </style>
</head>
<body class="min-h-screen transition-colors duration-300">
    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>
            <div class="flex items-center">
                <span class="mr-4 text-gray-300">Welcome, <?php echo htmlspecialchars($username); ?></span>
                <button id="darkModeToggle" class="mr-4 px-3 py-1 rounded-md bg-gray-600 text-white hover:bg-gray-500 transition duration-300">
                    <i class="fas fa-moon mr-2"></i>Dark Mode
                </button>
                <button id="logoutBtn" class="btn-danger px-4 py-2 rounded-md transition duration-300 bg-red-500 text-white hover:bg-red-600">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md mb-8 hover-effect">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Update User Details</h2>
            <form id="updateUserForm">
                <div class="mb-4">
                    <label for="username" class="block mb-2 text-gray-700 dark:text-gray-300">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200" required>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block mb-2 text-gray-700 dark:text-gray-300">New Password (leave blank to keep current)</label>
                    <input type="password" id="new_password" name="new_password" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                </div>
                <button type="submit" class="btn-primary px-4 py-2 rounded-md transition duration-300 bg-blue-500 text-white hover:bg-blue-600">
                    <i class="fas fa-save mr-2"></i>Update Details
                </button>
            </form>
        </div>
        
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md mb-8 hover-effect">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Delete Account</h2>
            <p class="mb-4 text-gray-600 dark:text-gray-300">Warning: This action cannot be undone.</p>
            <button id="deleteAccountBtn" class="btn-danger px-4 py-2 rounded-md transition duration-300 bg-red-500 text-white hover:bg-red-600">
                <i class="fas fa-trash-alt mr-2"></i>Delete Account
            </button>
        </div>

        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md hover-effect">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Existing Users</h2>
            <div class="overflow-x-auto table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-300">ID</th>
                            <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-300">Username</th>
                            <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-300">Email</th>
                            <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_users as $user): ?>
                        <tr class="border-b border-gray-200 dark:border-gray-700 table-row hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="py-3 px-4">
                                <button class="delete-user-btn btn-danger px-3 py-1 rounded-md transition duration-300 bg-red-500 text-white hover:bg-red-600" data-user-id="<?php echo $user['id']; ?>">
                                    <i class="fas fa-trash-alt mr-2"></i>Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="dashboard.js"></script>
</body>
</html>