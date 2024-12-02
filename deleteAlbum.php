<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['album_id'])) {
    $albumId = $_GET['album_id'];
} else {
    header("Location: index.php");
    exit();
}

$album = getAlbumById($pdo, $albumId);

if (!$album || $album['username'] !== $_SESSION['username']) {
    echo "Error: This album doesn't exist or you don't have permission to delete it.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Confirm Deletion</title>
</head>
<body>
    <h2>Are you sure you want to delete the album?</h2>
    <p>Album Name: <?php echo htmlspecialchars($album['album_name']); ?></p>
    <p>This action cannot be undone.</p>

    <form action="core/handleForms.php" method="GET">
        <input type="hidden" name="deleteAlbumBtn" value="1">
        <input type="hidden" name="album_id" value="<?php echo $albumId; ?>">
        <input type="submit" value="Yes, delete the album">
    </form>

    <br>
    <a href="index.php">Cancel and return to the homepage</a>
</body>
</html>
