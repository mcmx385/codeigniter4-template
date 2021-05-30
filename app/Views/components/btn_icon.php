<?php
if (!isset($color)) :
    $color = 'dark';
endif;
?>
<div class="col-6 col-md-4 col-lg-2 mb-1 p-1">
    <a href="<?php echo $link; ?>" class="py-2 btn btn-<?php echo $color; ?> w-100 h-100">
        <i class="<?php echo $icon; ?> fa-5x"></i>
        <div class="font-weight-bold"><?php echo $title; ?></div>
        <div style="font-size: small;"><?php echo $subtitle; ?></div>
    </a>
</div>