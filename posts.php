<?php
require 'vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->blog->posts;

// Fetch all posts from MongoDB
$posts = $collection->find([]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Posts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="posts.php">Posts</a></li>
            <li><a href="create_post.php">New Post</a></li>


            
            <?php if (!$isLoggedIn): ?>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            <?php else: ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <h2 style="text-align: center; margin-top: 20px;">📜 All Blog Posts</h2>
    
    <div class="posts-container">
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <img src="<?php echo htmlspecialchars($post->photo); ?>" alt="Post Image">
                <div class="post-content">
                    <a href="post_details.php?id=<?php echo $post->_id; ?>" class="post-title">
                        <?php echo htmlspecialchars($post->title); ?>
                    </a>
                    <p class="post-status">Status: <?php echo htmlspecialchars($post->status); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
