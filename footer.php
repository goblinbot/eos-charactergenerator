
  <div class="footer cell">

  </div>

</div> <!-- grid -->
  <?=EMSincludeJS()?>
  <script type="text/javascript">
    $(document).ready(function(){
      setTimeout(function(){
        $('body').removeClass('notransition');
      },400);

      checkGridSupport();
    });
  </script>
</body>
</html>
