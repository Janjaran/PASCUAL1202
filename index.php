<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="insertPhotoForm" style="display: flex; justify-content: center;">
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="#">Description</label>
                <input type="text" name="photoDescription" required>
            </p>
            <p>
                <label for="#">Photo Upload</label>
                <input type="file" name="image" required>
                <input type="submit" name="insertPhotoBtn" style="margin-top: 10px;">
            </p>
        </form>
    </div>

    <div class="albumsContainer" style="display: flex; justify-content: center; margin-top: 25px;">
        <h3>Your Albums</h3>
    </div>
    <?php
    $getAllAlbums = getAllAlbumsByUser($pdo, $_SESSION['username']);
    foreach ($getAllAlbums as $album) { ?>
        <div class="albumContainer" style="display: inline-block; margin-right: 20px; background-color: lightgray; border: solid 1px;">
            <h4><?php echo $album['album_name']; ?></h4>
            <a href="viewAlbum.php?album_id=<?php echo $album['album_id']; ?>">View Photos</a>
            <br>
            <a href="editAlbum.php?album_id=<?php echo $album['album_id']; ?>" style="color: blue;">Edit</a>
            <br>
            <a href="deleteAlbum.php?album_id=<?php echo $album['album_id']; ?>" style="color: red;">Delete</a>
        </div>
    <?php } ?>

    <div class="photosContainer" style="margin-top: 50px;">
        <h3>All Photos</h3>
        <?php $getAllPhotos = getAllPhotos($pdo); ?>
        <?php foreach ($getAllPhotos as $row) { ?>
            <div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
                <div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">
                    <img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">
                    <div class="photoDescription" style="padding:25px;">
                        <a href="profile.php?username=<?php echo $row['username']; ?>"><h2><?php echo $row['username']; ?></h2></a>
                        <p><i><?php echo $row['date_added']; ?></i></p>
                        <h4><?php echo $row['description']; ?></h4>
                        <?php if ($_SESSION['username'] == $row['username']) { ?>
                            <a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
                            <br>
                            <br>
                            <a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
