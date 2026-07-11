<?php
// globals
include_once __DIR__ . "/../../_includes/includes.php";
include_once APP_ROOT . "/header.php";

if (!isset($_SESSION)) {
  session_start();
}
// Validate that Joomla User is SL or Figu
if (!in_array("31", $jgroups, true) && !in_array("30", $jgroups, true)) {
  header('Status: 303 Moved Temporarily', false, 303);
  header('Location: ../../');
}
//End Validation
?>

<!DOCTYPE html>
<html lang="en" style="background-color:#262e3e;">

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./exif.js"></script>
  <script src="croppie.js"></script>
  <link rel="stylesheet" href="croppie.css" />

  <style>
    .main.cell {
      place-content: center;
    }
  </style>
</head>

<body class="notransition" onload="">

  <div class="main cell" align="center">
    <div class="panel-body" align="center">
      <h1>SL/NPC Photo Uploader</h1>
      <?php
      $filepath = APP_ROOT . '/img/passphoto/npc/' . $jid . '.jpg';
      $url = '../../img/passphoto/npc/' . $jid . '.jpg';
      if (file_exists($filepath)) {
        echo '<h2>Existing Profile Image</h2>';
        echo '<img src="' . $url . '">';
      }
      ?>
      <h2>Select<?php if (file_exists($filepath)) {
                  echo " New";
                } ?> Profile Image</h2>
      <input type="file" name="upload_image" id="upload_image" />
      <br />
      <div id="uploaded_image"></div>
      <div class="panel-body">
        <h3>Please submit a photo of your head and shoulders, taken against a solid color (preferably white) background. <br />
          Please use the below photos as an example of what you should submit. <br />
          This will be used to represent any NPC you might play, so ideally the photo should be of you dressed as generically as possible.</h3>
        <img src="../../img/Example.png">
      </div>
    </div>
  </div>
  <?php include APP_ROOT . '/footer.php'; ?>
</body>

</html>

<div id="uploadimageModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload & Crop Image</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 text-center">
            <div id="image_demo" style="width:350px; margin-top:30px"></div>
          </div>
          <div class="col-md-4" style="padding-top:30px;">
            <br />
            <br />
            <br />
            <button class="btn btn-success crop_image">Crop & Upload Image</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $viewchar = $jid;
?>

<script>
  var viewchar = "<?php echo $viewchar; ?>";
  $(document).ready(function() {

    $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width: 300,
        height: 400,
        type: 'rectangle' //circle
      },
      boundary: {
        width: 300,
        height: 400
      }
    });

    $('#upload_image').on('change', function() {
      var reader = new FileReader();
      reader.onload = function(event) {
        $image_crop.croppie('bind', {
          url: event.target.result
        }).then(function() {
          console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(this.files[0]);
      $('#uploadimageModal').modal('show');
    });
    $('.crop_image').click(function(event) {
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response) {
        $.ajax({
          url: "upload.php",
          type: "POST",
          data: {
            "image": response,
            "charid": viewchar
          },
          success: function(data) {
            $('#uploadimageModal').modal('hide');
            $('#uploaded_image').html(data);
          }
        });
      })
    });

  });
</script>