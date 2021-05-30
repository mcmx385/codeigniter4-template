<div class="container">
    <?php echo view('components/title', ['title' => 'Take attendance', 'link' => '/teacher/courses']); ?>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">Date:</span>
        </div>
        <form action="">
            <select name="date" id="" class="form-control w-100" onchange="location = this.value">
                <option value="">Select a date</option>
                <?php
                foreach ($data['lectures'] as $lecture) {
                ?>
                    <option value="<?php echo '/lecture/attendance/' . $data['course_id'] . '/' . $lecture->lecture_id; ?>" <?php if ($data['lecture_id'] == $lecture->lecture_id) : echo 'selected';
                                                                                                                            endif; ?>><?php echo $lecture->date; ?> <?php echo $lecture->start_time; ?>-<?php echo $lecture->end_time; ?></option>
                <?php
                }
                ?>
            </select>
        </form>
    </div>

    <section>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <th>Name</th>
                <th>Take attendance</th>
            </thead>
            <tbody>
                <?php
                foreach ($data['students'] as $student) {
                ?>
                    <tr>
                        <td><?php echo $student->name; ?></td>
                        <td><a href="/lecture/takeAttendance/0/<?php echo $data['lecture_id']; ?>/<?php echo $student->userid; ?>" class="btn btn-primary <?php if ($student->attendance_id) : echo 'disabled';
                                                                                                                                                            endif; ?>">Take</a> </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</div>