<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrightBytes</title>
    <!-- <link rel="stylesheet" href="style.css" > -->
     <style>
        
    .upload-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* غيّر height إلى min-height */
    flex-direction: column;
}

.container {
    background-color: #007BFF;
    border: 10px solid  #6DAEDB;
    padding: 40px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 400px;  
       max-width: 100%; 
}
.upload-box {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;  
    text-align: center;
}

.cameimg {
    margin: 0 auto;
    display: block; 
    margin-bottom: 15px; 
    width: 70px; 
    height: 70px;
}


.custom-file-upload {
    display: inline-flex;
    padding: 10px 20px;
    cursor: pointer;
    background-color: #173753;
    color: white;
    border-radius: 5px;
    font-size: 16px;
    justify-content: center;
    align-items: center;
    width: 100%; 
    text-align: center;
    margin-bottom: 10px;
}

input[type="file"] {
    display: none;
}
.upload-text {
    font-size: 14px;  
    color: white;
    margin-top: 10px;
    text-align: center;
}
@media (max-width: 600px) {
    .container {
        width: 90%; 
    }

    .custom-file-upload {
        font-size: 14px; 
    }
}
.centered-image {
    display: block;
    margin-top:50px;
    margin-left: auto;
    margin-right: auto;
    width: 500px; 
    border: 10px solid  #6DAEDB; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}
.comp-download{
    display: inline-flex;
    padding: 10px 20px;
    text-decoration: none;
    font-family: Arial;
    background-color: #173753;
    color: white;
    border-radius: 5px;
    margin-top: 30px;
    margin-left: 700px;
}
</style>
</head>
<body>
    <?php include 'home.php'; ?>

    <?php
        $isImageUploaded = false; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            if (!in_array($imageFileType, $allowedTypes)) {
                echo "Only JPG, JPEG and PNG files are allowed."; 
            } else {
                $compressedImage = compressImage($_FILES["image"]["tmp_name"], $target_file, 75); // 75 هو مستوى الجودة
        
                if ($compressedImage) {
                    $isImageUploaded = true; 
                    echo "<img src='$target_file' alt='Uploaded Image' class='centered-image'><br>";
                    echo "<a class='comp-download' href='$target_file' download >Download</a>";
                } else {
                    echo "حدث خطأ أثناء رفع أو ضغط الصورة.";
                }
            }
        }
    
        function compressImage($source, $destination, $quality) {
            $info = getimagesize($source);
        
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
                correctImageOrientation($image, $source);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
                imagealphablending($image, false);
                imagesavealpha($image, true);
            } else {
                return false;
            }

            if ($info['mime'] == 'image/jpeg') {
                imagejpeg($image, $destination, $quality); // ضغط JPEG
            } elseif ($info['mime'] == 'image/png') {
                imagepng($image, $destination); // ضغط PNG بدون فقد الجودة
            }
        
            imagedestroy($image);
        
            return $destination;
        }
    
        function correctImageOrientation(&$image, $filename) {
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($filename);
                if ($exif && isset($exif['Orientation'])) {
                    $orientation = $exif['Orientation'];
                    switch ($orientation) {
                        case 3:
                            $image = imagerotate($image, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($image, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($image, 90, 0);
                            break;
                    }
                }
            }
        }
    ?>

            <?php if (!$isImageUploaded): ?>
                <div class="upload-container">
                <div class="container">
                <form id="upload-form" action="" method="POST" enctype="multipart/form-data">
                    <div class="upload-box">
                        <img class="cameimg" src="img12.png" alt="Upload Icon">
                        <label for="file-upload" class="custom-file-upload">Choose Image</label>
                        <input id="file-upload" type="file" name="image" accept="image/*" required onchange="document.getElementById('upload-form').submit();">
                        <p class="upload-text">Or drag and drop here</p>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
