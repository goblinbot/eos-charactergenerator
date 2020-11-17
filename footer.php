<?php
if (!isset($APP)) die('No direct access allowed');
?>

<div class="footer cell">

  <p class="text-muted text-left">
    <i class="far fa-copyright"></i>&nbsp;<?= date("Y") ?>&nbsp;-&nbsp;Stichting Eos Dynamic. By Thijs&nbsp;Boerma
  </p>

  <p class="text-right">
    <span class="text-muted">Best used/viewed with </span><i class="fab fa-firefox"></i><span class="text-muted">&nbsp;and&nbsp;</span><i class="fab fa-chrome"></i>
  </p>

</div>

</div> <!-- grid -->
<script type="text/javascript" src="<?= $APP["header"] ?>/_includes/js/functions.js"></script>
</body>

</html>
<?php
