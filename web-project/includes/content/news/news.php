<?php 


$msg = "";

// Benutzer-Check
/*if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Zurück zu index.php, wenn nicht eingeloggt
    exit();
}*/

if (!isset($_SESSION['user_id'])) {
    // Kein Benutzer eingeloggt, setze is_admin auf 0
    $_SESSION['is_admin'] = 0;
}

// Prüfen, ob der Benutzer Admin ist
if ($_SESSION['is_admin'] !== 1) {
    // Falls der Benutzer kein Admin ist, verstecke die Formular-Option
    $showForm = false;
} else {
    $showForm = true;
}

if(isset($_POST['upload'])){
    // Connect to database
    $db = mysqli_connect("localhost","root", "","dbaccess");

     // Get latest index
     $query = "SELECT id FROM news ORDER BY id DESC LIMIT 1";
     $result = mysqli_query($db, $query);
 
     if ($result) {
         $row = mysqli_fetch_assoc($result);
     }

    // The path to store images
    $target = "./assets/news_original/".$row["id"]."_".basename($_FILES['image']['name']);

    $image = $_FILES['image']['name'];
    $text = $_POST['text'];
    $file_reference = "./assets/news_thumbnail/". 'thumbnail_' .$row["id"]."_".basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        if (resize($target)) {
            $msg = "Uploaded and resized successfully";
            $sql = "INSERT INTO news (image, text, file_reference) VALUES ('$image', '$text', '$file_reference')";
            mysqli_query($db, $sql); // Store the submitted data into the database table news
        } else {
            $msg = "Resize failed. Upload was not saved to the database.";
            // Optionally, delete the uploaded file if resize fails
            unlink($target);
        }
    } else {
        $msg = "Error occurred during upload.";
    }
    
}

// Functions
    function resize($filename) {
        $target_dir = "./assets/news_thumbnail/";
        $resizedFilename = $target_dir . 'thumbnail_' . basename($filename);
        
        $mimeType = mime_content_type($filename);
        switch ($mimeType) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($filename);
                break;
            default:
                echo "Unsupported image type.";
                return false;
        }

        list($width, $height) = getimagesize($filename);

        $targetWidth = 720;
        $targetHeight = 480;
        $targetAspectRatio = $targetWidth / $targetHeight;
        $sourceAspectRatio = $width / $height;

        if ($sourceAspectRatio > $targetAspectRatio) {
            // Original is wider
            $cropWidth = $height * $targetAspectRatio;
            $cropHeight = $height;
            $cropX = ($width - $cropWidth) / 2;
            $cropY = 0;
        } else {
            // Original is taller
            $cropWidth = $width;
            $cropHeight = $width / $targetAspectRatio;
            $cropX = 0;
            $cropY = ($height - $cropHeight) / 2;
        }

        $thumb = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresampled(
            $thumb, 
            $source, 
            0, 0, 
            $cropX, $cropY, 
            $targetWidth, $targetHeight, 
            $cropWidth, $cropHeight
        );

        imagejpeg($thumb, $resizedFilename, 90);

        imagedestroy($thumb);
        imagedestroy($source);

        echo "Resized image saved as: " . $resizedFilename;
        return true;
    }
?>





<!--- NEWS-SECTION --->
<div class="container mt-5">
    <h1 class="text-center mb-4">News</h1>

    <div class="row">
        <?php 
        $db = mysqli_connect("localhost","root", "","dbaccess");
        $sql = "SELECT * FROM news ORDER BY id desc";
        $result = mysqli_query($db,$sql);
        while($row = mysqli_fetch_array($result)){
            echo "<div class='col-lg-6 col-md-4 mb-4'>";
            echo "<div class='card shadow'>";
            echo "<div class='ratio ratio-16x9'>"; // Seitenverhältnis 16:9
            echo "<img src='" . $row["file_reference"] . "' class='card-img-top img-fluid' alt='Image'>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<p class='card-text fs-5'>".$row['text']."</p>";
            echo "<p class='card-text text-secondary fs-6'> <small>"."created at ".date('Y-m-d', strtotime($row['post_date']))."</small></p>";
            echo "</div></div></div>";
        }
        ?>
    </div>

    <?php if ($showForm): ?>
        <form  method="post" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="size" value="1000000">
            <div class="mb-3">
                <label for="imageInput" class="form-label">Upload Image</label>
                <input type="file" name="image" id="imageInput" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="textArea" class="form-label">Add the text</label>
                <textarea name="text" id="textArea" cols="40" rows="4" class="form-control" placeholder="Write something..." required></textarea>
            </div>
            <button type="submit" name="upload" class="btn btn-primary mb-5">Upload Image</button>
        </form>
    <?php endif; ?>

    <?php if ($msg): ?>
        <div class="alert alert-info mt-3" role="alert">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

</div>