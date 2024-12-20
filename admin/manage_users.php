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

// Fetch posts
$query = "SELECT * FROM users";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Users</title>
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
        <a href="../admin/dashboard.php" >Dashboard</a>
        <a href="../admin/manage_posts.php" >Manage Posts</a>
        <a href="../admin/manage_users.php" class="active">Manage Users</a>
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
            <h3 class="mb-4">Manage Users</h3>

            <!-- Add Post Button -->
            <div class="d-flex justify-content-between mb-3">
                <h4>Users</h4>

            </div>

            <!-- user Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($users = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $users['id']; ?></td>
                            <td><?php echo htmlspecialchars($users['username']); ?></td>
                            <td><?php echo htmlspecialchars($users['email']); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($users['created_at'])); ?></td>
                            <td>
                                <!-- Edit Post Button Triggering Modal -->
                                <a href="#" class="btn btn-sm btn-warning"  data-bs-target="#editPostModal"
                                   data-id="<?php echo $users['id']; ?>"
                                   data-username="<?php echo htmlspecialchars($users['username']); ?>"
                                   data-emailr="<?php echo htmlspecialchars($users['email']); ?>"     
                               > Edit</a>
                                <a href="users_delete.php?id=<?php echo $users['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   

    <!-- Edit User Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="users_edit.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edituserId" name="id" value="">

                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="editEmail" name="author" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
       <!-- Bootstrap JS -->
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Edit Post Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#editUserModal"]');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get data attributes from the clicked button
            const userId = button.getAttribute('data-id');
            const userUsername = button.getAttribute('data-username');
            const userEmail = button.getAttribute('data-email');

            // Set the values into the modal form fields
            document.getElementById('edituserId').value = userId;
            document.getElementById('editUsername').value = userUsername;
            document.getElementById('editEmail').value = userEmail;
        });
    });
});
</script>


    
</body>
</html>
