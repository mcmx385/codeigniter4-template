<div class="container">
    <?php echo view('components/title', ['title' => 'Course Students', 'link' => '/teacher/courses']); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Attendance Record</th>
        </thead>
        <tbody>
            <?php
            foreach ($data['students'] as $student) {
            ?>
                <tr>
                    <td><?php echo $student->id; ?></td>
                    <td><?php echo $student->name; ?></td>
                    <td><a href="/course/student_attendance/<?php echo $data['course_id']; ?>/<?php echo $student->id; ?>" class="btn btn-success"> View</a></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>