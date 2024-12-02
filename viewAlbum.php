<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$albumId = $_GET['album_id'];
$album = getAlbumById($pdo, $albumId);

if (!$album) {
    echo "Album not found!";
    exit;
}

$photos = getPhotosByAlbum($pdo, $albumId);

// Check if form is submitted to add a photo
if (isset($_POST['addPhotoBtn'])) {
    // Handle photo upload
    $photoDescription = $_POST['photoDescription'];
    $file = $_FILES['photo'];

    if ($file['error'] == 0) {
        $fileName = basename($file['name']);
        $fileTmpName = $file['tmp_name'];
        $filePath = 'images/' . $fileName;

        // Move uploaded file to the images directory
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Insert the photo into the photos table
            $insertPhotoSql = "INSERT INTO photos (photo_name, username, description) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($insertPhotoSql);
            $stmt->execute([$fileName, $_SESSION['username'], $photoDescription]);

            // Get the photo_id of the newly inserted photo
            $photoId = $pdo->lastInsertId();

            // Now insert the relationship into album_photos table
            $insertAlbumPhoto = insertPhotoToAlbum($pdo, $albumId, $photoId);

            if ($insertAlbumPhoto) {
                // Redirect to the same page to display the newly added photo
                header("Location: viewAlbum.php?album_id=" . $albumId);
                exit();
            } else {
                echo "Error linking photo to album.";
            }
        } else {
            echo "Error uploading photo.";
        }
    } else {
        echo "File upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo $album['album_name']; ?></title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div style="text-align: center; margin-top: 30px;">
        <h2><?php echo $album['album_name']; ?> - Photos</h2>
    </div>

    <!-- Add Photo Form -->
    <div style="text-align: center; margin-top: 20px;">
        <form action="viewAlbum.php?album_id=<?php echo $albumId; ?>" method="POST" enctype="multipart/form-data">
            <label for="photoDescription">Photo Description:</label><br>
            <input type="text" name="photoDescription" required><br><br>
            <label for="photo">Choose Photo:</label><br>
            <input type="file" name="photo" required><br><br>
            <input type="submit" name="addPhotoBtn" value="Add Photo">
        </form>
    </div>

    <!-- Display Existing Photos -->
    <?php foreach ($photos as $photo) { ?>
        <div class="photoContainer" style="margin-top: 20px; text-align: center;">
            <img src="images/<?php echo $photo['photo_name']; ?>" alt="photo" style="width: 50%;"><br>
            <p><?php echo $photo['description']; ?></p>
        </div>
    <?php } ?>
</body>
</html>
