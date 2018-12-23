<?php require_once '../common/header-admin.php'; ?>

<form id="form-student">
    <input type="text" id="studentid" name="studentid" placeholder="studentid">
    <input type="text" id="firstname" name="firstname" placeholder="firstname">
    <input type="text" id="lastname" name="lastname" placeholder="lastname">
    <input type="text" id="middlename" name="middlename" placeholder="middlename">
    <select id="yearlevelid" name="yearlevelid"></select>
    <select id="departmentid" name="departmentid"></select>
    <select id="courseid" name="courseid"></select>
    <input type="text" id="username" name="username" placeholder="username">
    <input type="text" id="password" name="password" placeholder="password">
    <input type="text" id="pin" name="pin" placeholder="pin">
</form>

<table id="table-student">
    <thead>
        <tr>
            <th>TeacherId</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>MiddleName</th>
            <th>YearLevel</th>
            <th>DepartmentName</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<button type="button" id="btn-add">Add</button>
<button type="button" id="btn-update">Update</button>
<button type="button" id="btn-cancel">Cancel</button>

<div id="modal-student-sss" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Student Section/Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>List of Student Sections/Subjects</h6>
        <table id="table-student-sss">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <h6>List of Sections/Subjects</h6>
        <table id="table-section-subject">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button id="btn-save-student-sss" type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        var studentData = [];
        var tableStudent = null;
        var modalStudentSSS = $('#modal-student-sss');
        var studentId = null;
        var tableSectionSubject = null;
        var tableStudentSSS = null;
        var studentSSSData = [];

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addStudent.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-student').serializeArray(),
                success: function(result) {
                    getAllStudent();
                    clearForm();
                }
            });
        });

        $('#table-student').on('click', '.btn-edit', function() {
            $('#studentid').val($(this).attr('data-studentid'));
            $('#firstname').val($(this).attr('data-firstname'));
            $('#lastname').val($(this).attr('data-lastname'));
            $('#middlename').val($(this).attr('data-middlename'));
            $('#yearlevelid').val($(this).attr('data-yearlevelid'));
            $('#departmentid').val($(this).attr('data-departmentid'));
            $('#courseid').val($(this).attr('data-courseid'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateStudent.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-student').serializeArray(),
                success: function(result) {
                    getAllStudent();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllStudent();

        function getAllStudent() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllStudent.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    studentData = result.data;

                    if (tableStudent !== null) {
                        tableStudent.destroy();
                    }

                    studentData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.StudentId + `</td>
                                    <td>` + row.FirstName + `</td>
                                    <td>` + row.LastName + `</td>
                                    <td>` + row.MiddleName + `</td>
                                    <td>` + row.YearLevel + `</td>
                                    <td>` + row.DepartmentName + `</td>
                                    <td>` + row.CourseName + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-studentid="` + row.StudentId + `"
                                            data-firstname="` + row.FirstName + `"
                                            data-lastname="` + row.LastName + `"
                                            data-middlename="` + row.MiddleName + `"
                                            data-yearlevelid="` + row.YearLevelId + `"
                                            data-departmentid="` + row.DepartmentId + `"
                                            data-courseid="` + row.CourseId + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-edit-student-sss" 
                                            data-toggle="modal"
                                            data-studentid="` + row.StudentId + `"
                                        >Edit Section/Subject</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-student tbody').html(html);
                    tableStudent = $('#table-student').DataTable();
                }
            });

        }

        function clearForm() {
            $('#studentid').val('');
            $('#firstname').val('');
            $('#lastname').val('');
            $('#middlename').val('');
            $('#yearlevelid').val('');
            $('#departmentid').val('');
            $('#courseid').val('');
            $('#username').val('');
            $('#password').val('');
            $('#pin').val('');
        }

        getAllYearLevel();

        function getAllYearLevel() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllYearLevel.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var yearLevelData = result.data;

                    yearLevelData.forEach(function(row, i) {
                        html += `<option value="` + row.YearLevelId + `">` + row.YearLevel + `</option>`;
                    });

                    $('#yearlevelid').html(html);
                }
            });
        }

        
        getAllDepartment();

        function getAllDepartment() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllDepartment.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var departmentData = result.data;

                    departmentData.forEach(function(row, i) {
                        html += `<option value="` + row.DepartmentId + `">` + row.DepartmentName + `</option>`;
                    });

                    $('#departmentid').html(html);
                }
            });
        }

        
        getAllCourse();

        function getAllCourse() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllCourse.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var courseData = result.data;

                    courseData.forEach(function(row, i) {
                        html += `<option value="` + row.CourseId + `">` + row.CourseName + `</option>`;
                    });

                    $('#courseid').html(html);
                }
            });
        }

        $('#table-student tbody').on('click', '.btn-edit-student-sss', function() {
            studentId = $(this).attr('data-studentid');
            modalStudentSSS.modal('show');
            getAllStudentSSSByStudentId();
        });

        function getAllStudentSSSByStudentId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllStudentSSSByStudentId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'studentid', value : studentId }],
                success: function(result) {
                    var html = ``;
                    studentSSSData = result.data;

                    if (tableStudentSSS !== null) {
                        tableStudentSSS.destroy();
                    }

                    studentSSSData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SectionName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-remove-student-sss"
                                            data-studentsectionid="` + row.StudentSectionId + `"
                                        >Remove</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-student-sss tbody').html(html);
                    tableStudentSSS = $('#table-student-sss').DataTable();

                    getAllSectionSubjectSchedule();
                }
            }); 
        }

        function getAllSectionSubjectSchedule() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSectionSubjectSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var sectionSubjectData = result.data;

                    if (tableSectionSubject !== null) {
                        tableSectionSubject.destroy();
                    }

                    sectionSubjectData.forEach(function(row, i) {
                        if (isSubjectExist(row.SubjectId) === false) {
                            html += `<tr>
                                    <td>` + row.SectionName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-add-student-sss"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                        >Add</button>
                                    </td>
                                </tr>`;
                        }
                    });

                    $('#table-section-subject tbody').html(html);
                    tableSectionSubject = $('#table-section-subject').DataTable();
                }
            });
        }

        modalStudentSSS.on('click', '.btn-add-student-sss', function() {
            var sssid = $(this).attr('data-sectionsubjectscheduleid');

            $.ajax({
                url: '<?php echo base_url('queries/addStudentSSS.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'studentid', value : studentId },
                    { name : 'sectionsubjectscheduleid', value : sssid }
                ],
                success: function(result) {
                    getAllStudentSSSByStudentId();
                }
            });
        });

        modalStudentSSS.on('click', '.btn-remove-student-sss', function() {
            var studentSectionId = $(this).attr('data-studentsectionid');

            $.ajax({
                url: '<?php echo base_url('queries/deleteStudentSSS.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'studentsectionid', value : studentSectionId }
                ],
                success: function(result) {
                    getAllStudentSSSByStudentId();
                }
            });
        });

        function isSubjectExist(subjectId) {
            var isAdded = false;
            studentSSSData.some(function(row) {
                if (row.SubjectId === subjectId) {
                    isAdded = true;
                    return true;
                }
            });
            return isAdded;
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>