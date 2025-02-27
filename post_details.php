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

// If no post is found, show an error message
if (!$post) {
    die("Post not found.");
}

// Handle like button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["like"])) {
    $collection->updateOne(['_id' => $id], ['$inc' => ['likes' => 1]]);
    header("Refresh:0"); // Reload the page to update the like count
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
    $comment = trim($_POST["comment_text"]);
    if (!empty($comment)) {
        $collection->updateOne(['_id' => $id], ['$push' => ['comments' => $comment]]);
        header("Refresh:0"); // Reload the page to show the new comment
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
    <h2><?php echo htmlspecialchars($post->title); ?></h2>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($post->author); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($post->status); ?></p>
    <img src="<?php echo htmlspecialchars($post->photo); ?>" width="300">
    <p><?php echo nl2br(htmlspecialchars($post->description)); ?></p>
    
    <form method="POST">
        <button type="submit" name="like">Like (<?php echo $post->likes ?? 0; ?>)</button>
    </form>

    <h3>Comments</h3>
    <ul>
        <?php foreach ($post->comments ?? [] as $comment): ?>
            <li><?php echo htmlspecialchars($comment); ?></li>
        <?php endforeach; ?>
    </ul>
    
    <form method="POST">
        <textarea name="comment_text" placeholder="Write a comment..." required></textarea>
        <button type="submit" name="comment">Post Comment</button>
    </form>
</body>
</html>
