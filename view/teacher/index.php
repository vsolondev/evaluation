<?php require_once '../common/header-admin.php'; ?>

<form id="form-teacher">
    <input type="text" id="teacherid" name="teacherid" placeholder="teacherid">
    <input type="text" id="firstname" name="firstname" placeholder="firstname">
    <input type="text" id="lastname" name="lastname" placeholder="lastname">
    <input type="text" id="middlename" name="middlename" placeholder="middlename">
    <select id="departmentid" name="departmentid"></select>
    <input type="text" id="username" name="username" placeholder="username">
    <input type="text" id="password" name="password" placeholder="password">
    <input type="text" id="pin" name="pin" placeholder="pin">
</form>

<table id="table-teacher">
    <thead>
        <tr>
            <th>TeacherId</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>MiddleName</th>
            <th>DepartmentName</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<button type="button" id="btn-add">Add</button>
<button type="button" id="btn-update">Update</button>
<button type="button" id="btn-cancel">Cancel</button>

<div id="modal-teacher-sss" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Teacher Section/Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>List of Teacher Sections/Subjects</h6>
        <table id="table-teacher-sss">
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        var teacherData = [];
        var tableTeacher = null;
        var modalTeacherSSS = $('#modal-teacher-sss');
        var teacherId = null;
        var tableSectionSubject = null;
        var tableTeacherSSS = null;
        var teacherSSSData = [];
        var allTeacherSSSData = [];

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addTeacher.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-teacher').serializeArray(),
                success: function(result) {
                    getAllTeacher();
                    clearForm();
                }
            });
        });

        $('#table-teacher').on('click', '.btn-edit', function() {
            $('#teacherid').val($(this).attr('data-teacherid'));
            $('#firstname').val($(this).attr('data-firstname'));
            $('#lastname').val($(this).attr('data-lastname'));
            $('#middlename').val($(this).attr('data-middlename'));
            $('#departmentid').val($(this).attr('data-departmentid'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateTeacher.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-teacher').serializeArray(),
                success: function(result) {
                    getAllTeacher();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllTeacher();

        function getAllTeacher() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllTeacher.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    teacherData = result.data;

                    if (tableTeacher !== null) {
                        tableTeacher.destroy();
                    }

                    teacherData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.TeacherId + `</td>
                                    <td>` + row.FirstName + `</td>
                                    <td>` + row.LastName + `</td>
                                    <td>` + row.MiddleName + `</td>
                                    <td>` + row.DepartmentName + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-teacherid="` + row.TeacherId + `"
                                            data-firstname="` + row.FirstName + `"
                                            data-lastname="` + row.LastName + `"
                                            data-middlename="` + row.MiddleName + `"
                                            data-departmentid="` + row.DepartmentId + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-edit-teacher-sss" 
                                            data-toggle="modal"
                                            data-teacherid="` + row.TeacherId + `"
                                        >Edit Section/Subject</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-teacher tbody').html(html);
                    tableTeacher = $('#table-teacher').DataTable();
                }
            });

        }

        function clearForm() {
            $('#teacherid').val('');
            $('#firstname').val('');
            $('#lastname').val('');
            $('#middlename').val('');
            $('#departmentid').val('');
            $('#username').val('');
            $('#password').val('');
            $('#pin').val('');
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
        
        $('#table-teacher tbody').on('click', '.btn-edit-teacher-sss', function() {
            teacherId = $(this).attr('data-teacherid');
            modalTeacherSSS.modal('show');
            getAllTeacherSSSByTeacherId();
        });

        function getAllTeacherSSSByTeacherId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllTeacherSSSByTeacherId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'teacherid', value : teacherId }],
                success: function(result) {
                    var html = ``;
                    teacherSSSData = result.data;

                    if (tableTeacherSSS !== null) {
                        tableTeacherSSS.destroy();
                    }

                    teacherSSSData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SectionName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-remove-teacher-sss"
                                            data-teachersectionid="` + row.TeacherSectionId + `"
                                        >Remove</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-teacher-sss tbody').html(html);
                    tableTeacherSSS = $('#table-teacher-sss').DataTable();

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

                    getAllTeacherSSS(function() {
                        if (tableSectionSubject !== null) {
                            tableSectionSubject.destroy();
                        }

                        sectionSubjectData.forEach(function(row, i) {
                            if (isSubjectExist(row.SectionSubjectScheduleId) === false && isSubjectAlreadyHandled(row.SectionSubjectScheduleId) === false) {
                                html += `<tr>
                                        <td>` + row.SectionName + `</td>
                                        <td>` + row.SubjectAcronym + `</td>
                                        <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                        <td>
                                            <button 
                                                class="btn-add-teacher-sss"
                                                data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                            >Add</button>
                                        </td>
                                    </tr>`;
                            }
                        });

                        $('#table-section-subject tbody').html(html);
                        tableSectionSubject = $('#table-section-subject').DataTable();
                    });
                }
            });
        }

        modalTeacherSSS.on('click', '.btn-add-teacher-sss', function() {
            var sssid = $(this).attr('data-sectionsubjectscheduleid');

            $.ajax({
                url: '<?php echo base_url('queries/addTeacherSSS.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'teacherid', value : teacherId },
                    { name : 'sectionsubjectscheduleid', value : sssid }
                ],
                success: function(result) {
                    getAllTeacherSSSByTeacherId();
                }
            });
        });

        modalTeacherSSS.on('click', '.btn-remove-teacher-sss', function() {
            var teacherSectionId = $(this).attr('data-teachersectionid');

            $.ajax({
                url: '<?php echo base_url('queries/deleteTeacherSSS.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'teachersectionid', value : teacherSectionId }
                ],
                success: function(result) {
                    getAllTeacherSSSByTeacherId();
                }
            });
        });

        function isSubjectExist(sectionSubjectScheduleId) {
            var isAdded = false;
            teacherSSSData.some(function(row) {
                if (row.SectionSubjectScheduleId === sectionSubjectScheduleId) {
                    isAdded = true;
                    return true;
                }
            });
            return isAdded;
        }

        function getAllTeacherSSS(callBack) {
            $.ajax({
                url: '<?php echo base_url('queries/getAllTeacherSSS.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    allTeacherSSSData = result.data;
                    callBack(allTeacherSSSData);
                }
            });
        }

        function isSubjectAlreadyHandled(sectionSubjectScheduleId) {
            var isHandled = false;

            allTeacherSSSData.some(function(row) {
                if (row.SectionSubjectScheduleId === sectionSubjectScheduleId) {
                    isHandled = true;
                    return true;
                }
            });

            return isHandled;
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>