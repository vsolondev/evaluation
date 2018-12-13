<?php require_once '../common/header-admin.php'; ?>

<form id="form-department">
    <input type="text" id="departmentid" name="departmentid" placeholder="departmentid">
    <input type="text" id="departmentname" name="departmentname" placeholder="departmentname">
</form>

<table id="table-department">
    <thead>
        <tr>
            <th>DepartmentId</th>
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
        var departmentData = [];
        var tableDepartment = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addDepartment.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-department').serializeArray(),
                success: function(result) {
                    getAllDepartment();
                    clearForm();
                }
            });
        });

        $('#table-department').on('click', '.btn-edit', function() {
            $('#departmentid').val($(this).attr('data-departmentid'));
            $('#departmentname').val($(this).attr('data-departmentname'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateDepartment.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-department').serializeArray(),
                success: function(result) {
                    getAllDepartment();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllDepartment();

        function getAllDepartment() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllDepartment.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    departmentData = result.data;

                    if (tableDepartment !== null) {
                        tableDepartment.destroy();
                    }

                    departmentData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.DepartmentId + `</td>
                                    <td>` + row.DepartmentName + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-departmentid="` + row.DepartmentId + `"
                                            data-departmentname="` + row.DepartmentName + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-department tbody').html(html);
                    tableDepartment = $('#table-department').DataTable();
                }
            });
        }

        function clearForm() {
            $('#departmentid').val('');
            $('#departmentname').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>