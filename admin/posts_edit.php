<?php
require("../includes/database.php");

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch the existing post details if an ID is provided
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch post from the database
    $query = "SELECT * FROM blog_posts WHERE id = '$postId'";
    $result = mysqli_query($connect, $query);

    // Check if query succeeded
    if (!$result) {
        echo "<div class='alert alert-danger'>Error executing query: " . mysqli_error($connect) . "</div>";
        exit;
    }

    // Check if the post exists
    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Post not found!</div>";
        exit;
    }
}

// Handle form submission
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
        // Update the post in the database
        $query = "UPDATE blog_posts SET title = '$title', author = '$author', category = '$category', description = '$content' WHERE id = '$postId'";

        if (mysqli_query($connect, $query)) {
            echo "<div class='alert alert-success'>Post updated successfully!</div>";
            // Redirect to the admin dashboard
            header("Location: admin/dashboard.php");
            exit;
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
    <title>Admin Dashboard - Edit Post</title>
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
    <h2 class="mb-4">Edit Post</h2>
    <div class="form-container">
        <form action="posts_edit.php?id=<?php echo $postId; ?>" method="POST" id="postForm">
            <?php 
    $postId = $_GET['id'];
    $query = "SELECT * FROM blog_posts WHERE id = '$postId'";
    $post = mysqli_fetch_assoc(mysqli_query($connect, $query));
    ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($post['author']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($post['category']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="description" rows="6" required><?php echo htmlspecialchars($post['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</div>
</body>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script>
    let editor;
    document.addEventListener('DOMContentLoaded', () => {
        ClassicEditor.create(document.querySelector('#content'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => console.error(error));

        // Sync content to textarea on form submit
        document.getElementById('postForm').addEventListener('submit', (event) => {
            const content = editor.getData();
            document.querySelector('#content').value = content;
        });
    });
</script>
</html>
