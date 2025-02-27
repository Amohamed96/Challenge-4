<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

// Connect to MongoDB
$client = new Client("mongodb://localhost:27017");
$collection = $client->blog->posts;

// Validate and get post ID from URL
if (!isset($_GET['id']) || !preg_match('/^[0-9a-fA-F]{24}$/', $_GET['id'])) {
    die("Invalid post ID");
}

$id = new ObjectId($_GET['id']);
$post = $collection->findOne(['_id' => $id]);

if (!$post) {
    die("Post not found.");
}

// Handle like button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["like"])) {
    $collection->updateOne(['_id' => $id], ['$inc' => ['likes' => 1]]);
    header("Refresh:0");
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
    $comment = trim($_POST["comment_text"]);
    if (!empty($comment)) {
        $collection->updateOne(['_id' => $id], ['$push' => ['comments' => $comment]]);
        header("Refresh:0");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post->title); ?></title>
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
    <div class="post-container">
        <h2><?php echo htmlspecialchars($post->title); ?></h2>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($post->author); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($post->status); ?></p>
        <img src="<?php echo htmlspecialchars($post->photo); ?>" alt="Post Image">
        <p><?php echo nl2br(htmlspecialchars($post->description)); ?></p>
        
        <form method="POST">
            <button type="submit" name="like">👍 Like (<?php echo $post->likes ?? 0; ?>)</button>
        </form>

        <div class="comments-section">
            <h3>💬 Comments</h3>
            <ul class="comments-list">
                <?php foreach ($post->comments ?? [] as $comment): ?>
                    <li><?php echo htmlspecialchars($comment); ?></li>
                <?php endforeach; ?>
            </ul>
            
            <form method="POST">
                <textarea name="comment_text" placeholder="Write a comment..." required></textarea>
                <button type="submit" name="comment">➕ Post Comment</button>
            </form>
        </div>
    </div>
</body>
</html>
