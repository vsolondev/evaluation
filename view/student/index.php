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

<script>
    $(document).ready(function() {
        var studentData = [];
        var tableStudent = null;

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
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>