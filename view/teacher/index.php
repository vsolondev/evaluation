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

<script>
    $(document).ready(function() {
        var teacherData = [];
        var tableTeacher = null;

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
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>