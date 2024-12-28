<?php
require("../includes/database.php");
require("../includes/functions.php");
session_start();

// Secure admin access
secure();

if (!$_SESSION['is_admin']) {
    set_message("Access Denied! You are not authorized to view this page.");
    header("Location: /");
    exit;
}

// Fetch posts
$query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
        <a href="../admin/dashboard.php" >Dashboard</a>
        <a href="../admin/manage_posts.php" class="active">Manage Posts</a>
        <a href="../admin/manage_users.php" >Manage Users</a>
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
            <h3 class="mb-4">Manage Posts</h3>

            <!-- Add Post Button -->
            <div class="d-flex justify-content-between mb-3">
                <h4>Posts</h4>
                <a href="posts_add.php">
                    <button type="button" class="btn btn-success">Add Post</button>
                </a>
            </div>

            <!-- Posts Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['author']); ?></td>
                            <td><?php echo htmlspecialchars($post['category']); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($post['created_at'])); ?></td>
                            <td>
                                <a href="posts_edit.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="posts_delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
