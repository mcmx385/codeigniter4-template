<div class="row py-2">
    <div class="col-3"><?php echo view('components/return_button', ['link' => $link]); ?></div>
    <div class="col-6">
        <h2 class="text-center"><?php echo $title; ?></h2>
    </div>
    <div class="col-3"></div>
    <div class="col-12">
        <?php echo view('components/status'); ?>
    </div>
</div>