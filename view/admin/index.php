<?php require_once '../common/header-admin.php'; ?>

<form id="form-admin">
    <input type="text" id="adminid" name="adminid" placeholder="adminid">
    <input type="text" id="firstname" name="firstname" placeholder="firstname">
    <input type="text" id="lastname" name="lastname" placeholder="lastname">
    <input type="text" id="middlename" name="middlename" placeholder="middlename">
    <input type="text" id="username" name="username" placeholder="username">
    <input type="text" id="password" name="password" placeholder="password">
    <input type="text" id="pin" name="pin" placeholder="pin">
</form>

<table id="table-admin">
    <thead>
        <tr>
            <th>AdminId</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>MiddleName</th>
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
        var adminData = [];
        var tableAdmin = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addAdmin.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-admin').serializeArray(),
                success: function(result) {
                    getAllAdmin();
                    clearForm();
                }
            });
        });

        $('#table-admin').on('click', '.btn-edit', function() {
            $('#adminid').val($(this).attr('data-admin-id'));
            $('#firstname').val($(this).attr('data-firstname'));
            $('#lastname').val($(this).attr('data-lastname'));
            $('#middlename').val($(this).attr('data-middlename'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateAdmin.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-admin').serializeArray(),
                success: function(result) {
                    getAllAdmin();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllAdmin();

        function getAllAdmin() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllAdmin.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    adminData = result.data;

                    if (tableAdmin !== null) {
                        tableAdmin.destroy();
                    }

                    adminData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.AdminId + `</td>
                                    <td>` + row.FirstName + `</td>
                                    <td>` + row.LastName + `</td>
                                    <td>` + row.MiddleName + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-admin-id="` + row.AdminId + `"
                                            data-firstname="` + row.FirstName + `"
                                            data-lastname="` + row.LastName + `"
                                            data-middlename="` + row.MiddleName + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-admin tbody').html(html);
                    tableAdmin = $('#table-admin').DataTable();
                }
            });

        }

        function clearForm() {
            $('#adminid').val('');
            $('#firstname').val('');
            $('#lastname').val('');
            $('#middlename').val('');
            $('#username').val('');
            $('#password').val('');
            $('#pin').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>