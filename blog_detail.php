<?php
require("./includes/config.php");
require("./includes/functions.php");

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $connect = mysqli_connect('localhost', 'root', '', 'php_cms');

    // Fetch the blog post by ID
    $query = "SELECT * FROM blog_posts WHERE id = '$postId'";
    $result = mysqli_query($connect, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    // Redirect to home if no post ID is passed
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <?php include("./includes/header.php"); ?>

    <div class="container my-4">
        <h2 class="text-center mb-4"><?php echo htmlspecialchars($post['title']); ?></h2>
        <img src="images/<?php echo $post['image']; ?>" class="img-fluid" alt="Blog Image">
        <p class="text-muted small">By <?php echo htmlspecialchars($post['author']); ?> | <?php echo date("M d, Y", strtotime($post['created_at'])); ?></p>
        <div class="content">
            <p><?php echo nl2br(htmlspecialchars($post['description'])); ?></p>
            <!-- Add more content here if necessary -->
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
