<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-admin label {
        display: inline-block;
        width: 120px;
    }

    #form-admin input,
    #form-admin select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form id="form-admin">
                <input type="text" id="adminid" name="adminid" placeholder="adminid" hidden>

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
                    </div>
                    <div class="col-12 col-md-6">
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

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-admin" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


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
                                            class="btn-edit btn btn-primary btn-sm"
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