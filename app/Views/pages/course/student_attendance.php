<div class="container">
    <?php echo view('components/title', ['title' => 'Student all attendance record']); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>ID</th>
            <th>Date</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Presence</th>
        </thead>
        <tbody>
            <?php
            foreach ($data['student_records'] as $record) {
            ?>
                <tr>
                    <td><?php echo $record->lecture_id; ?></td>
                    <td><?php echo $record->date; ?></td>
                    <td><?php echo $record->start_time; ?></td>
                    <td><?php echo $record->end_time; ?></td>
                    <td><?php echo $record->attendance_id ? 'present' : 'absent'; ?></td>
                </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>