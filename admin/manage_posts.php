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
$connect = mysqli_connect('localhost', 'root', '', 'php_cms');

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
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPostModal">
                    Add Post
                </button>
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
                                <!-- Edit Post Button Triggering Modal -->
                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPostModal" 
   data-id="<?php echo $post['id']; ?>"
   data-title="<?php echo htmlspecialchars($post['title']); ?>"
   data-author="<?php echo htmlspecialchars($post['author']); ?>"
   data-category="<?php echo htmlspecialchars($post['category']); ?>"
   data-description="<?php echo htmlspecialchars($post['description']); ?>">
    Edit
</a>

                                <a href="posts_delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  <!-- Add Post Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="posts_add.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <!-- description -->
                        <!-- Text Editor -->
                        <textarea class="form-control" id="content" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Edit Post Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="posts_edit.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editPostId" name="id" value="">

                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAuthor" class="form-label">Author</label>
                            <input type="text" class="form-control" id="editAuthor" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="editCategory" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="editContent" class="form-label">Content</label>
                            <textarea class="form-control" id="editContent content" name="content" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>

<!-- <script>
    // Initialize CKEditor for both Add and Edit modals
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    let editEditor; // To reinitialize CKEditor dynamically
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.querySelector('#editPostModal');
        editModal.addEventListener('shown.bs.modal', function () {
            if (!editEditor) {
                ClassicEditor
                    .create(document.querySelector('#editContent'))
                    .then(editor => {
                        editEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    });
</script> -->


<script>
    // Populate Edit Post Modal
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('[data-bs-target="#editPostModal"]');
        const editModal = document.getElementById('editPostModal');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const postId = button.getAttribute('data-id');
                const postTitle = button.getAttribute('data-title');
                const postAuthor = button.getAttribute('data-author');
                const postCategory = button.getAttribute('data-category');
                const postContent = button.getAttribute('data-description');

                document.getElementById('editPostId').value = postId;
                document.getElementById('editTitle').value = postTitle;
                document.getElementById('editAuthor').value = postAuthor;
                document.getElementById('editCategory').value = postCategory;

                // Initialize CKEditor for edit modal dynamically
                if (window.editEditor) {
                    window.editEditor.setData(postContent);
                } else {
                    ClassicEditor
                        .create(document.querySelector('#editContent'))
                        .then(editor => {
                            window.editEditor = editor;
                            editor.setData(postContent);
                        })
                        .catch(error => console.error(error));
                }
            });
        });
    });

    // Initialize CKEditor for Add Post Modal
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => console.error(error));
</script>

<script>
    // Ensure CKEditor content is synced with the hidden textarea before submission
    document.addEventListener('DOMContentLoaded', function () {
        // For the Add Post modal
        const addPostForm = document.querySelector('form[action="posts_add.php"]');
        if (addPostForm) {
            addPostForm.addEventListener('submit', function (e) {
                const contentEditor = CKEDITOR.instances['content'];
                if (contentEditor) {
                    // Sync the editor content with the textarea
                    document.getElementById('content').value = contentEditor.getData();
                }
            });
        }

        // For the Edit Post modal
        const editPostForm = document.querySelector('form[action="posts_edit.php"]');
        if (editPostForm) {
            editPostForm.addEventListener('submit', function (e) {
                const editContentEditor = window.editEditor; // CKEditor instance for the edit modal
                if (editContentEditor) {
                    // Sync the editor content with the textarea
                    document.getElementById('editContent').value = editContentEditor.getData();
                }
            });
        }
    });
</script>



    
</body>
</html>
