<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="Home.css">  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    body{
    margin: 0;
    padding: 0;
}
nav{
    width: 100%;
    height: 50px;
    background:#2892D7;
    overflow: auto;   
}
ul {
    padding: 0;
    margin: 0 0 0 150px;
    list-style: none;
}
li{
    float: right;
}
.logo{
    position: absolute;
    margin-top: -80px;
    margin-left: 10px;    
}
nav a {
    position: relative;
    text-decoration: none;
    color: white;
    font-size: 18px;
    padding: 10px 15px;
}

nav a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px; 
    width: 100%;
    height: 2px; 
    background-color: white;
    transform: scaleX(0); 
    transform-origin: bottom right;
    transition: transform 0.3s ease-out;
}

nav a:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
}




  </style>
</head>
<body>
    <div class="">
    <img class="logo" src="logo.png" width=200px >
    </div>
        <div class="nav">
    <nav class="navbar-default">
    <ul class="navbar-nav">
    <li><a href="gallery-image.php">Image Gallery</a></li>
      <li><a href="resize-image.php">Image Resizer</a></li>
      <li><a href="crop-image.php">Image Cropper</a></li>
      <li><a href="compress-image.php">Image Compressor</a></li>
    </ul>
    </nav>
      </div>
</body>
</html>
