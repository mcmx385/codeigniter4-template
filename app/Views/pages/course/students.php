<div class="container">
    <?php echo view('components/title', ['title' => 'Course Students', 'link' => '/teacher/courses']); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>ID</th>
            <th>Name</th>
        </thead>
        <tbody>
            <?php
            foreach ($data['students'] as $student) {
            ?>
                <tr>
                    <td><?php echo $student->student_id; ?></td>
                    <td><?php echo $student->name; ?></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>