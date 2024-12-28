<?php
require("../includes/database.php");
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $content = mysqli_real_escape_string($connect, $_POST['description']);

    // Validate required fields
    if (empty($title) || empty($author) || empty($category) || empty($content)) {
        echo "<div class='alert alert-danger'>All fields are required!</div>";
    } else {
        // Insert into database
        $query = "INSERT INTO blog_posts (title, author, category, description, created_at) 
                  VALUES ('$title', '$author', '$category', '$content', NOW())";

        if (mysqli_query($connect, $query)) {
            echo "<div class='alert alert-success'>Post added successfully!</div>";
            header("Location: admin/dashboard.php");
        } else {
            echo "<div class='alert alert-danger'>SQL Error: " . mysqli_error($connect) . "</div>";
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Post</title>
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
        .form-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="../admin/dashboard.php">Dashboard</a>
    <a href="../admin/manage_posts.php" class="active">Manage Posts</a>
    <a href="../admin/manage_users.php">Manage Users</a>
    <a href="../index.php">Back</a>
    <a href="../logout.php">Logout</a>
</div>
<div class="main-content">
    <h2 class="mb-4">Add New Post</h2>
    <div class="form-container">
        <form action="posts_add.php" method="POST" id="postForm">
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
                <textarea class="form-control" id="description" name="description" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>
</div>
</body>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script>
     CKEDITOR.replace("description");
    // let editor;
    // document.addEventListener('DOMContentLoaded', () => {
    //     ClassicEditor.create(document.querySelector('#description'))
    //         .then(newEditor => {
    //             editor = newEditor;
    //         })
    //         .catch(error => console.error(error));

    //     // Sync content to textarea on form submit
    //     document.getElementById('postForm').addEventListener('submit', (event) => {
    //         const content = editor.getData();
    //         document.querySelector('#content').value = content;
    //     });
    // });
</script>
</html>
