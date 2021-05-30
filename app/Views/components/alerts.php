<?php
if (isset($_GET['status']) && $_GET['status'] !== "") :
?>
    <p class="text-center text-warning font-weight-bold"><i class="fas fa-check fa-4x"></i><br><?php echo $status; ?></p>
<?php
endif;
?>