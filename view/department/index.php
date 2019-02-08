<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-department label {
        display: inline-block;
        width: 120px;
    }

    #form-department input,
    #form-department select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-department">
                <input type="text" id="departmentid" name="departmentid" placeholder="departmentid" hidden>

                <label for="departmentname">Department: </label>
                <input type="text" id="departmentname" name="departmentname" placeholder="departmentname">
            </form>
        </div>

        <div class="col-12 col-md-6">
            <button type="button" id="btn-add" class="btn btn-primary btn-sm">Add</button>
            <button type="button" id="btn-update" class="btn btn-secondary btn-sm">Update</button>
            <button type="button" id="btn-cancel" class="btn btn-white btn-sm">Cancel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-department" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>DepartmentId</th>
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
                                            class="btn-edit btn btn-primary btn-sm"
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