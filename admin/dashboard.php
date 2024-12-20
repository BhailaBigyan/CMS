<?php
require("../includes/config.php");
require("../includes/functions.php");
session_start();
// Secure admin access
secure();

if (!$_SESSION['is_admin']) {
    set_message("Access Denied! You are not authorized to view this page.");
    header("Location: /");
    exit;
}
$connect = mysqli_connect('localhost', 'root', '', 'php_cms');

$query = "SELECT * FROM blog_posts WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY created_at DESC";
$result = mysqli_query($connect, $query);

// Fetch counts
$total_users = count_users($connect);
$total_posts = count_posts($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 10px;
        }

        .sidebar a {
            color: #ccc;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Admin Panel</h4>
        <a href="../admin/dashboard.php" class="active">Dashboard</a>
        <a href="../admin/manage_posts.php">Manage Posts</a>
        <a href="../admin/manage_users.php">Manage Users</a>
        <a href="../index.php">Back</a>
        <a href="../logout.php" >Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Welcome, Admin!</span>
            </div>
        </nav>

        <!-- Dashboard Overview -->
        <div class="container">
            <h3 class="mb-4">Dashboard Overview</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Posts</h5>
                            <p class="card-text fs-4"><?php echo $total_posts; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Active Users</h5>
                            <p class="card-text fs-4"><?php echo $total_users; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Table -->
            <h4 class="mt-5 mb-3">Recent Posts</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                   <?php while ($blog_posts = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $blog_posts['id']; ?></td>
                        <td><?php echo htmlspecialchars($blog_posts['title']); ?></td>
                        <td><?php echo htmlspecialchars($blog_posts['author']); ?></td>
                        <td><?php echo htmlspecialchars($blog_posts['category']); ?></td>
                        <td><?php echo date($blog_posts['created_at']); ?></td>
                        
                    </tr>
                <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>