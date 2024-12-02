<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// Handle form submission for album name update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['albumName'])) {
    $albumName = $_POST['albumName'];
    $albumId = $_GET['album_id']; // Get the album ID from URL

    $editAlbumResponse = editAlbum($pdo, $albumName, $albumId);
    if ($editAlbumResponse) {
        header("Location: index.php"); // Redirect to the homepage after updating the album
    } else {
        echo "Error editing album!";
    }
}

// Fetch the current album details
$albumId = $_GET['album_id'];
$album = getAlbumById($pdo, $albumId);

if (!$album) {
    echo "Album not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Album</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <form action="editAlbum.php?album_id=<?php echo $album['album_id']; ?>" method="POST">
            <label for="albumName">Album Name</label>
            <input type="text" name="albumName" value="<?php echo $album['album_name']; ?>" required>
            <input type="submit" value="Update Album">
        </form>
    </div>
</body>
</html>
