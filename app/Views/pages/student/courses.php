<div class="container">
    <?php echo view('components/title', ['title' => 'Courses']); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Teacher</th>
            <th>Attendance Record</th>
        </thead>
        <tbody>
            <?php
            foreach ($data['courses'] as $course) {
            ?>
                <tr>
                    <td><?php echo $course->course_id; ?></td>
                    <td><?php echo $course->code; ?></td>
                    <td><?php echo $course->name; ?></td>
                    <td><?php echo $course->teacher_name; ?></td>
                    <td><a class="btn btn-success" href="/lecture/attendance_record/<?php echo $course->course_id; ?>">View</a></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>