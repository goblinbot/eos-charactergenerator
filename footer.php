
  <div class="footer cell">

    <p class="text-muted">&copy;&nbsp;<?=date("Y")?>&nbsp;-&nbsp;Stichting Eos Dynamic. By Thijs Boerma</p>

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
