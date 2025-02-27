<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $author = $_POST["author"];
    $status = $_POST["status"];

    // Image Upload
    $targetDir = "upload/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);

    $collection->insertOne([
        'title' => $title,
        'description' => $description,
        'author' => $author,
        'status' => $status,
        'photo' => $targetFile,
        'likes' => 0
    ]);

    header("Location: posts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Create a New Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="author" placeholder="Author" required>
        <select name="status">
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
        </select>
        <input type="file" name="photo" required>
        <button type="submit">Create Post</button>
    </form>
</body>
</html>
