<?php
require("./includes/config.php");
require("./includes/functions.php");

$connect = mysqli_connect('localhost', 'root', '', 'php_cms');

// Fetch all blog posts
$postsQuery = "SELECT id, title, description, image, category, author, created_at FROM blog_posts where category ='Culture' ORDER BY created_at DESC";
$postsResult = mysqli_query($connect, $postsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blogs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css ">
</head>
<body>
    <?php include("./includes/header.php"); ?>
    
    <div class="container my-4">
        <h2 class="text-center mb-4">All Blog Posts</h2>
        <div class="row">
            <?php while ($post = mysqli_fetch_assoc($postsResult)): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/<?php echo $post['image']; ?>" class="card-img-top" alt="Blog Image">
                        <div class="card-body">
                            <div class="category-badge"><?php echo htmlspecialchars($post['category']); ?></div>
                            <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($post['description']), 0, 100); ?>...</p>
                            <p class="text-muted small">By <?php echo htmlspecialchars($post['author']); ?> | <?php echo date("M d, Y", strtotime($post['created_at'])); ?></p>
                            <a href="blog_detail.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
