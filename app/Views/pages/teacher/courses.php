<div class="container">
    <h2 class="text-center py-2">Teacher Courses</h2>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Course Students</th>
            <th>Lecture Attendance</th>
            <th>Attendance URL</th>
        </thead>
        <tbody>
            <?php
            $teacher_courses = $data['teacher_courses'];
            if (count($teacher_courses) > 0) {
                foreach ($teacher_courses as $course) {
            ?>
                    <tr>
                        <td><?php echo $course->code; ?></td>
                        <td><?php echo $course->name; ?></td>
                        <td><a class="btn btn-success" href="/course/students/<?php echo $course->course_id; ?>">View</a></td>
                        <td><a class="btn btn-primary" href="/lecture/attendance/<?php echo $course->course_id; ?>">Take</a></td>
                        <td><a class="btn btn-danger" href="/lecture/urls/<?php echo $course->course_id; ?>">Publish</a></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>