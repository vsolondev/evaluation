<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-teacher label {
        display: inline-block;
        width: 120px;
    }

    #form-teacher input,
    #form-teacher select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }

    #image {
        width: 150px;
        height: auto;
        min-height: 150px;
        display: block;
        margin-top: 30px;
        margin-bottom: 10px;
        border: 1px solid;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-3">
            <img src="#" id="image">
            <form action="form-image">
                <label for="imagefile">Image File: </label>
                <input type="text" name="accountid" id="accountid" hidden>
                <input type="file" name="imagefile" id="imagefile" accept=".jpg,.jpeg,.gif,.png">
                <div>Allowed File Type : .jpeg, .jpg, .png, .gif</div>
            </form>
        </div>
        <div class="col-12 col-md-9">
            <form id="form-teacher">
                <input type="text" id="teacherid" name="teacherid" placeholder="teacherid" hidden>

                <div class="row mt-4 mb-5">
                    <div class="col-12 col-md-6">
                        <label for="firstname">Firstname: </label>
                        <input type="text" id="firstname" name="firstname" placeholder="firstname">
                        <br>
                        <label for="lastname">Lastname: </label>
                        <input type="text" id="lastname" name="lastname" placeholder="lastname">
                        <br>
                        <label for="middlename">Middlename: </label>
                        <input type="text" id="middlename" name="middlename" placeholder="middlename">
                        <br>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="departmentid">Department: </label>
                        <select id="departmentid" name="departmentid"></select>
                        <br>
                        <label for="username">Username: </label>
                        <input type="text" id="username" name="username" placeholder="username">
                        <br>
                        <label for="password">Password: </label>
                        <input type="text" id="password" name="password" placeholder="password">
                        <br>
                        <label for="pin">Pin: </label>
                        <input type="text" id="pin" name="pin" placeholder="pin">

                        <br>
                        <div class="mt-4">
                            <button type="button" id="btn-add" class="btn btn-primary btn-sm">Add</button>
                            <button type="button" id="btn-update" class="btn btn-secondary btn-sm">Update</button>
                            <button type="button" id="btn-cancel" class="btn btn-white btn-sm">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-teacher" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


<div id="modal-edit-subjects" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Teacher Subjects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>List of Assigned Subjects</h6>
        <table id="table-assigned-subjects" class="table table-striped table-sm table-borderless nowrap">
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

        <h6 class="mt-5">List of Unassigned Subjects</h6>
        <table id="table-unassigned-subjects" class="table table-striped table-sm table-borderless nowrap">
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
        var modalEditSubjects = $('#modal-edit-subjects');
        var teacherId = null;
        var tableAssignedSubjects = null;
        var tableUnassignedSubjects = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addTeacher.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-teacher').serializeArray(),
                success: function(result) {
                    // Upload image starts here
                    var formData = new FormData();
                    formData.append('file', $('#imagefile')[0].files[0]);

                    // The account id is from the latest created account see addTeacher.php
                    formData.append('accountid', result.accountid);

                    $.ajax({
                        url: '<?php echo base_url('queries/uploadImage.php'); ?>',
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        cache: false,
                        data: formData
                    });
                    
                    getAllTeacher();
                    clearForm();
                }
            });
        });

        $('#table-teacher').on('click', '.btn-edit', function() {
            $('#accountid').val($(this).attr('data-accountid'));
            getImageByAccountId($(this).attr('data-accountid'));

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
                    // Update image starts here
                    var formData = new FormData();
                    formData.append('file', $('#imagefile')[0].files[0]);

                    // The account id is from the #accountid hidden input
                    formData.append('accountid', $('#accountid').val());

                    $.ajax({
                        url: '<?php echo base_url('queries/uploadImage.php'); ?>',
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        cache: false,
                        data: formData
                    });
                    
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
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-accountid="` + row.AccountId + `"
                                            data-teacherid="` + row.TeacherId + `"
                                            data-firstname="` + row.FirstName + `"
                                            data-lastname="` + row.LastName + `"
                                            data-middlename="` + row.MiddleName + `"
                                            data-departmentid="` + row.DepartmentId + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-edit-subjects btn btn-secondary btn-sm" 
                                            data-toggle="modal"
                                            data-teacherid="` + row.TeacherId + `"
                                        >Assigned/Unassigned Subjects</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-teacher tbody').html(html);
                    tableTeacher = $('#table-teacher').DataTable();
                }
            });

        }

        function clearForm() {
            $('#image').attr('src', '#');
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
        
        $('#table-teacher tbody').on('click', '.btn-edit-subjects', function() {
            teacherId = $(this).attr('data-teacherid');
            modalEditSubjects.modal('show');
            getAllAssignedSubjectsByTeacherId();
            getAllUnassignedSubjects();
        });

        function getAllAssignedSubjectsByTeacherId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllAssignedSubjectsByTeacherId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'teacherid', value : teacherId }],
                success: function(result) {
                    var html = ``;
                    var assignedSubjectsData = result.data;

                    if (tableAssignedSubjects !== null) {
                        tableAssignedSubjects.destroy();
                    }

                    assignedSubjectsData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SectionName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-unassign-subject btn btn-secondary btn-sm"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                        >Unassign</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-assigned-subjects tbody').html(html);
                    tableAssignedSubjects = $('#table-assigned-subjects').DataTable();
                }
            }); 
        }

        function getAllUnassignedSubjects() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllUnassignedSubjects.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var unassignedSubjectsData = result.data;

                    if (tableUnassignedSubjects !== null) {
                        tableUnassignedSubjects.destroy();
                    }

                    unassignedSubjectsData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SectionName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-assign-subject btn btn-primary btn-sm"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                        >Assign</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-unassigned-subjects tbody').html(html);
                    tableUnassignedSubjects = $('#table-unassigned-subjects').DataTable();
                }
            });
        }

        modalEditSubjects.on('click', '.btn-assign-subject', function() {
            var sssid = $(this).attr('data-sectionsubjectscheduleid');

            $.ajax({
                url: '<?php echo base_url('queries/assignSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'teacherid', value : teacherId },
                    { name : 'sectionsubjectscheduleid', value : sssid }
                ],
                success: function(result) {
                    getAllAssignedSubjectsByTeacherId();
                    getAllUnassignedSubjects();
                }
            });
        });

        modalEditSubjects.on('click', '.btn-unassign-subject', function() {
            var sssid = $(this).attr('data-sectionsubjectscheduleid');

            $.ajax({
                url: '<?php echo base_url('queries/unassignSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'sectionsubjectscheduleid', value : sssid }
                ],
                success: function(result) {
                    getAllAssignedSubjectsByTeacherId();
                    getAllUnassignedSubjects();
                }
            });
        });

        function getImageByAccountId(accountid) {
            $.ajax({
                url: '<?php echo base_url('queries/getImageByAccountId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'accountid' , value : accountid }],
                success: function(result) {
                    $('#image').attr('src', result.image);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>