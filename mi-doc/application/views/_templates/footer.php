  </div>

    <!-- JavaScript -->
    <script src="<?php echo URL.'public/'; ?>js/jquery-1.10.2.js"></script>
    <script src="<?php echo URL.'public/'; ?>js/bootstrap.js"></script>

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
</body>

</html>