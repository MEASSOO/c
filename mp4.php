<?php
  // Create database connection
  $db = mysqli_connect("panel.freehosting.com", "meassoco_measso", "abdo12", "meassoco_database");

  // Initialize message variable
  $msg = "";
  $sSQL= 'SET CHARACTER SET utf8';
  mysqli_query($db,$sSQL) 
  or die ('Can\'t charset in DataBase');
  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['file']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($db, $_POST['text']);

  	// image file directory
  	$target = "files/".basename($image);

  	$sql = "INSERT INTO posts_mp4 (image, text) VALUES ('$image', '$image_text')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM posts_mp4");
  ?>
 <DOCTYPE html>
   <html>
     <head>
     <link href="https://cdn.jsdelivr.net/npm/vlitejs@4/dist/vlite.css" rel="stylesheet" crossorigin />
    <script src="https://cdn.jsdelivr.net/npm/vlitejs@4" crossorigin></script>
     
     </head>
     <body>
 <form id="mp4_form" method="POST" action="add_post.php" enctype="multipart/form-data">
   <input type="text" placeholder="عنوان المنشور" name="post_text">
   <br/>
   <input type="file" value="اختر الملف " name="file">
   <br/>
   <input type="submit" value="نشر" name="upload">
   </form>


   <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div class='container'>";
      	echo "<h3>" . $row["text"] . "</h3>";
      	echo "<video id='id" . $row["id"] . "' class='vlite-js' src='" . $row["file"] . "'></video>";
        echo "</div>";
        echo "<br/>";
        echo "<script>";
        echo "new Vlitejs('#id" . $row["id"] . "', { });";
        echo "</script>";
    }
  ?>

     

  
     </body>
   </html>
