<?php
// globals
include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
include_once($APP["root"] . "/_includes/functions.global.php");
include_once($APP["root"] . "/header.php");

if (!isset($_SESSION)) {
  session_start();
}
// Validate that viewChar belongs to logged in Joomla User
$charID = $_GET["viewChar"];
$sql2 = "SELECT `characterID`,`accountID` FROM `ecc_characters` WHERE `characterID` = $charID";
$res2 = $UPLINK->query($sql2) or trigger_error(mysqli_error($UPLINK));
if (mysqli_num_rows($res2) > 0) {
  $character = mysqli_fetch_assoc($res2);
  if ($character['accountID'] != $jid) {
    header("location: {$APP['header']}/index.php");
    exit();
  }
} else {
  header("location: {$APP['header']}/index.php");
  exit();
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
      <h1>Select Profile Image</h2>
        <input type="file" name="upload_image" id="upload_image" />
        <br />
        <div id="uploaded_image"></div>
        <div class="panel-body">
          <h3>Please submit a photo of your head and shoulders, taken against a solid color (preferably white) background. <br />
            Please use the below photos as an example of what you should submit. <br />
            This will be printed on your character's IC ID Card, so ideally the photo should be of you dressed as your character would appear.</h3>
          <img src="../../img/Example.png">
        </div>
    </div>
  </div>
  <?php include $APP["root"] . '/footer.php'; ?>
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
<?php $viewchar = $_GET['viewChar'];
?>

<script>
  var viewchar = "<?php echo $viewchar; ?>";
  $(document).ready(function() {

    $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width: 200,
        height: 200,
        type: 'square' //circle
      },
      boundary: {
        width: 300,
        height: 300
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