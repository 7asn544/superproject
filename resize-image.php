<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrightBytes</title>
    <style>
        
        .upload-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh; 
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

#re-download,#re-img{
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
input[type="number"] {
    width: 180px; 
    padding: 10px;
    font-size: 16px;
    border: 2px solid #aad5f6; 
    border-radius: 10px; 
    background-color: #f5f5f5; 
    box-shadow: none; 
    outline: none; 
    color: #333; 
    /* display: inline-block; */
    /* padding: 10px 20px; */
    border-radius: 5px;
    margin-top: 30px;
}

input[type="number"]::placeholder {
    color: #a3a3a3; 
}

input[type="number"]:focus {
    border-color: #aad5f6; 
}
    </style>
</head>
<body>
    <?php include 'home.php'; ?>
            <div class='king page'>
        <?php
            // Handle image upload
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
                // Upload directory
                $upload_dir = 'uploads/';
                $uploaded_file = $upload_dir . basename($_FILES['image']['name']);

                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
                    echo "<img src='$uploaded_file' alt='Uploaded Image' class='centered-image'>";

                    // Show resize options (form will appear after image is uploaded)
                    echo "
                    <form action='' method='post'class='form-container'>
                        <input type='hidden' name='image_path' value='$uploaded_file'>
                        <div><input type='number' name='width' id='width-size' required style='margin-left: 500px;' Placeholder='width'>
                        <input  type='number' name='height' id='height-size' required style='margin-left: 100px;' Placeholder='height'></div>
                        <button type='submit' name='resize'id='re-img'>Resize Image</button>
                    </form>";
                } else {
                    echo "Error uploading image.";
                }
            } elseif (isset($_POST['resize'])) {
                // Handle image resizing
                $width = intval($_POST['width']);
                $height = intval($_POST['height']);
                $image_path = $_POST['image_path'];

                // Get image info
                $image_info = getimagesize($image_path);
                $mime_type = $image_info['mime'];

                // Create image from file based on MIME type
                switch ($mime_type) {
                    case 'image/jpeg':
                        $src_img = imagecreatefromjpeg($image_path);
                        break;
                    case 'image/png':
                        $src_img = imagecreatefrompng($image_path);
                        break;
                    case 'image/gif':
                        $src_img = imagecreatefromgif($image_path);
                        break;
                    default:
                        echo "Unsupported image type!";
                        exit;
                }

                // Create a new true color image with the desired dimensions
                $dst_img = imagecreatetruecolor($width, $height);

                // Resize the image
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $width, $height, imagesx($src_img), imagesy($src_img));

                // Save the resized image
                $resized_image_path = 'uploads/resized_image_' . time() . '.jpg';
                imagejpeg($dst_img, $resized_image_path);

                // Free memory
                imagedestroy($src_img);
                imagedestroy($dst_img);

                // Display resized image and download button
                echo "<img src='$resized_image_path' alt='Resized Image' class='centered-image'><br><br>";
                echo "<a id='re-download' href='$resized_image_path' download >Download</a>";
            } else {
                // If no image has been uploaded, show the upload form
                ?>
                <div class="upload-container">
                <div class="container">
                <form id="upload-form" action="" method="POST" enctype="multipart/form-data">
                    <div class="upload-box">
                        <img class="cameimg" src="img12.png" alt="Upload Icon">
                        <br>
                        <label for="file-upload" class="custom-file-upload">Choose Image</label>
                        <input id="file-upload" type="file" name="image" accept="image/*" required onchange="document.getElementById('upload-form').submit();">
                        <p class="upload-text">Or drag and drop here</p>
                    </div>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    </div>
</body>
</html>
