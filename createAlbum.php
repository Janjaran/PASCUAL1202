<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// Handle form submission for album creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['albumName'])) {
    $albumName = $_POST['albumName'];
    $username = $_SESSION['username'];

    $createAlbumResponse = createAlbum($pdo, $albumName, $username);
    if ($createAlbumResponse) {
        header("Location: index.php"); // Redirect to the homepage after creating the album
    } else {
        echo "Error creating album!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Create Album</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <form action="createAlbum.php" method="POST">
            <label for="albumName">Album Name</label>
            <input type="text" name="albumName" required>
            <input type="submit" value="Create Album">
        </form>
    </div>
</body>
</html>
