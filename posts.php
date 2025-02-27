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
    <h2>All Blog Posts</h2>
    
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="post_details.php?id=<?php echo $post->_id; ?>">
                    <img src="<?php echo $post->photo; ?>" width="100">
                    <strong><?php echo $post->title; ?></strong> (<?php echo $post->status; ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
