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
            <p><?php echo nl2br($post['description']); ?> </p>
            <!-- Add more content here if necessary -->
        </div>
    </div>
    <div class="container mt-4">
    <h4>Engagement Section</h4>

    <!-- Social Media Icons -->
    <div class="d-flex align-items-center mb-3">
        <span class="me-3">Share on:</span>
        <a href="https://facebook.com" target="_blank" class="me-2">
            <img src="https://img.icons8.com/ios-filled/30/facebook--v1.png" alt="Facebook">
        </a>
        <a href="https://twitter.com" target="_blank" class="me-2">
            <img src="https://img.icons8.com/ios-filled/30/twitter.png" alt="Twitter">
        </a>
        <a href="https://linkedin.com" target="_blank" class="me-2">
            <img src="https://img.icons8.com/ios-filled/30/linkedin.png" alt="LinkedIn">
        </a>
        <a href="https://whatsapp.com" target="_blank" class="me-2">
            <img src="https://img.icons8.com/ios-filled/30/whatsapp.png" alt="WhatsApp">
        </a>
    </div>

    <!-- Like and Share Buttons -->
    <div class="d-flex align-items-center mb-4">
        <button type="button" class="btn btn-outline-primary me-3">
            <i class="bi bi-hand-thumbs-up"></i> Like
        </button>
        <button type="button" class="btn btn-outline-success">
            <i class="bi bi-share"></i> Share
        </button>
    </div>

    <!-- Comment Section -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Comments
        </div>
        <div class="card-body">
            <!-- Existing Comments -->
            <div id="commentSection">
                <!-- Placeholder for dynamically loaded comments -->
                <p>No comments yet. Be the first to comment!</p>
            </div>

            <!-- Add Comment Form -->
            <form id="addCommentForm" method="POST" action="add_comment.php">
                <div class="mb-3">
                    <label for="commentText" class="form-label">Leave a Comment</label>
                    <textarea class="form-control" id="commentText" name="comment" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
    </div>
</div>


    <?php include("./includes/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
