<div class="container">
    <?php echo view('components/title', ['title' => 'Attendance Record', 'link' => '/student/courses']); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>ID</th>
            <th>Date</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Attendance</th>
            <th>Attendance and Lecture Material</th>
        </thead>
        <tbody>
            <?php
            foreach ($data['records'] as $record) {
            ?>
                <tr>
                    <td><?php echo $record->lecture_id; ?></td>
                    <td><?php echo $record->date; ?></td>
                    <td><?php echo $record->start_time; ?></td>
                    <td><?php echo $record->end_time; ?></td>
                    <td><?php echo $record->attendance_id ? 'present' : 'absent'; ?></td>
                    <td><a href="/lecture/takeAttendance/1/<?php echo $record->lecture_id; ?>" class="<?php echo $record->attendance_id ? 'text-muted' : ''; ?>"><?php echo $_SERVER['SERVER_NAME']; ?>/lecture/takeAttendance/1/<?php echo $record->lecture_id; ?></a></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>