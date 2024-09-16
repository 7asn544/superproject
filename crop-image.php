<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Crop Example</title>
    <!-- إضافة مكتبة Cropper.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
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
            display: inline;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #173753;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            justify-content: center;
            align-items: center;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
        .custom-file-upload-corp{
            display: inline;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #173753;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            margin-top:10px;
            margin-bottom: 10px;
            margin-left: 700px;
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

        .crop-container {
            display: flex;
            justify-content: center; /* توسيط أفقي */
            align-items: center; /* توسيط عمودي */
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            width: 600px;
            /* height: 200px; تعديل الارتفاع ليكون مربعًا */
            border: 10px solid #6DAEDB;
            border-radius: 10px;
            background-color: white;
            overflow: hidden; /* تأكد من أن الصورة لا تتجاوز الحاوية */
        }

        .preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* لتناسب الصورة داخل الحاوية */
        }

        .hidden {
            display: none;
        }
        .centered-image{
                    display: block;
                margin-top:50px;
                margin-left: auto;
                margin-right: auto;
                width: 500px; /* يمكنك تعديل العرض حسب الحاجة */
                border: 10px solid  #6DAEDB; /* إضافة إطار للصورة */
                border-radius: 10px; /* جعل الزوايا مستديرة */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* إضافة ظل للصورة */
        }
        #download-link {
            margin-left:700px ;
        }
    </style>
</head>
<body>
    <?php include 'home.php'; ?>

    <div id="upload-container" class="upload-container">
        <div class="container">
            <div class="upload-box">
                <img class="cameimg" src="img12.png" alt="Upload Icon">
                <label for="file-upload" class="custom-file-upload">Choose Image</label>
                <input id="file-upload" type="file" accept="image/*" onchange="loadImage(this)">
                <p class="upload-text">Or drag and drop here</p>
            </div>
        </div>
    </div>

    <div id="crop-container" class="hidden">
        <div class="crop-container">
            <img id="image" class="preview"><br>
        </div>
        <button type="button" id="crop-button" class="custom-file-upload-corp" onclick="cropImage()">Crop Image</button>
    </div>

    <form id="save-cropped-form" action="" method="POST" class="hidden">
        <input type="hidden" name="cropped_image" id="cropped_image_input">
    </form>

    <div id="result-container" class="hidden">
        <img id="cropped-image" class="centered-image"><br>
        <a id="download-link" class="custom-file-upload" href="#" download>Download</a>
    </div>

    <script>
        var cropper;
        var uploadedImageURL;

        // تحميل الصورة عند رفعها
        function loadImage(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image').src = e.target.result;
                    document.getElementById('upload-container').classList.add('hidden');  // إخفاء فورم رفع الصورة
                    document.getElementById('crop-container').classList.remove('hidden');  // إظهار فورم القص

                    var image = document.getElementById('image');
                    cropper = new Cropper(image, {
                        aspectRatio: NaN, // اختيار أبعاد حرة
                        viewMode: 1,
                        background: false, // إزالة الخلفية الرمادية
                        crop(event) {
                            document.getElementById('crop-x').value = Math.round(event.detail.x);
                            document.getElementById('crop-y').value = Math.round(event.detail.y);
                            document.getElementById('crop-width').value = Math.round(event.detail.width);
                            document.getElementById('crop-height').value = Math.round(event.detail.height);
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        // قص الصورة
        function cropImage() {
            var canvas = cropper.getCroppedCanvas();
            var croppedImageURL = canvas.toDataURL('image/png');
            document.getElementById('cropped_image_input').value = croppedImageURL;

            // إخفاء فورم القص وإظهار الصورة المحفوظة وزر التحميل
            document.getElementById('crop-container').classList.add('hidden');
            document.getElementById('result-container').classList.remove('hidden');
            document.getElementById('cropped-image').src = croppedImageURL;
            document.getElementById('download-link').href = croppedImageURL;
        }
    </script>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cropped_image'])) {
            $cropped_image_data = $_POST['cropped_image'];
            $cropped_image_data = str_replace('data:image/png;base64,', '', $cropped_image_data);
            $cropped_image_data = str_replace(' ', '+', $cropped_image_data);

            $cropped_image_file = 'uploads/cropped_image_' . time() . '.png';
            file_put_contents($cropped_image_file, base64_decode($cropped_image_data));

            echo '<img src="' . $cropped_image_file . '" class="centered-image-dow"><br>';
            echo '<a class="comp-download" href="' . $cropped_image_file . '" download>Download Cropped Image</a>';
        }
    ?>
</body>
</html>
