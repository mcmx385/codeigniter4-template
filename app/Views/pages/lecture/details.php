<div class="container">
    <?php echo view('components/title', ['title' => 'Lecture']); ?>
    <div class="row">
        <div class="col-12">
            <h5 class="font-weight-bold">Details</h5>
        </div>
        <div class="col">Date: <?php echo $data['lecture']->date; ?></div>
        <div class="col">Time: <?php echo $data['lecture']->start_time; ?> - <?php echo $data['lecture']->end_time; ?></div>
        <div class="col-12">
            <h5 class="font-weight-bold">Topic</h5>
            <ol>
                <li>Linear Algebra</li>
                <li>Discrete Math</li>
                <li>Advanced algorithm</li>
            </ol>
        </div>
    </div>
</div>