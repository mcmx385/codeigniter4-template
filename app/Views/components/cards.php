<div class="row text-center">
    <?php
    foreach ($result as $key => $value) :
    ?>
        <div class="card col-6 col-lg-3 py-3">
            <div class="card-body">
                <h2><?php echo $value; ?></h2>
                <p><?php echo $key; ?></p>
            </div>
        </div>
    <?php
    endforeach;
    ?>
</div>