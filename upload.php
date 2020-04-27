<?php
if(isset($_POST['submit'])){
          if (isset ($_FILES['new_image'])){
              $imagename = $_GET['viewChar'].".jpg";
              $source = $_FILES['new_image']['tmp_name'];
              $target = "images/".$imagename;
              move_uploaded_file($source, $target);

              $imagepath = $imagename;
              $save = "images/" . $imagepath; //This is the new file you saving
              $file = "images/" . $imagepath; //This is the original file

              if (($img_info = getimagesize($source)) === FALSE)
                die("Image not found or not an image");

              list($width, $height) = getimagesize($file) ; 

              $modwidth = 500; 
              $modheight = $height / ($width / $modwidth) ; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 

              switch ($img_info[2]) {
                case IMAGETYPE_GIF  : $src = imagecreatefromgif($file);  break;
                case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($file); break;
                case IMAGETYPE_PNG  : $src = imagecreatefrompng($file);  break;
                default : die("Unknown filetype");
              }

              imagecopyresampled($tn, $src, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

              imagejpeg($tn, $save, 100) ; 

//            echo "Large image: <img src='images/".$imagepath."'><br>";  
          }
        }
?>
