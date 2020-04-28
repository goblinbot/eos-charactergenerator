<?php
  // globals
  include_once($_SERVER["DOCUMENT_ROOT"] . "/eoschargen/_includes/config.php");
  include_once($APP["root"] . "/_includes/functions.global.php");
if (!isset($APP)) die('No direct access allowed');


  if(!isset($jid) || $jid == false || $jid == null || $jid == "") {

    if(!isset($APP["loginpage"]) || $APP["loginpage"] == "" || $APP["loginpage"] == "/" || $APP["loginpage"] == "#") {

      die('You are not logged in, and no valid login page has been set. Please contact Eos IT for more information. [ ERR: 101 ]');
      exit();

    } else {

      header("location: ".$APP["loginpage"]);
      exit();

    }

  }

  $sheetArr = getCharacterSheets();
  if(!isset($_SESSION)) {
    session_start();
  }

?>

<!DOCTYPE html>
<html lang="en" style="background-color:#262e3e;">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="theme-color" content="#262e3e">

  <noscript>
    <style>div { display:none!important; }</style>
  </noscript>

  <title>CHARGEN</title>

  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?=$APP['header']?>/_includes/css/style.css" />
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="croppie.js"></script>
		<link rel="stylesheet" href="croppie.css" />
    </head>  
<body class="notransition" onload="">

  <noscript>
    <p style="font-size:24px;padding:30px 15px;text-align:center;">This application needs JavaScript to work. Please enable JavaScript.</p>
    <p style="text-align:center;">:(</p>
  </noscript>


        <div class="container" style="text-align:center">
      <img src="../../img/outpost-icc-pm.png" alt="logo" title="ICC logo" height='64'/>
          <br />
          <br />
          <br />
      <br />
      <br />
			<div class="panel panel-default">
  				<div class="panel-heading">Select Profile Image</div>
  				<div class="panel-body" align="center">
  					<input type="file" name="upload_image" id="upload_image" />
  					<br />
  					<div id="uploaded_image"></div>
  				</div>
  			</div>
  		</div>
<?php include './footer.php'; ?>
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
  						<br/>
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
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });
  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        data:{"image": response, "charid": viewchar},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
      });
    })
  });

});  
</script>
