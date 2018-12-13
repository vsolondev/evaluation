<?php require_once '../common/header-admin.php'; ?>

<form id="form-yearlevel">
    <input type="text" id="yearlevelid" name="yearlevelid" placeholder="yearlevelid">
    <input type="text" id="yearlevel" name="yearlevel" placeholder="yearlevel">
</form>

<table id="table-yearlevel">
    <thead>
        <tr>
            <th>YearLevelId</th>
            <th>YearLevel</th>
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
        var yearlevelData = [];
        var tableYearLevel = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addYearLevel.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-yearlevel').serializeArray(),
                success: function(result) {
                    getAllYearLevel();
                    clearForm();
                }
            });
        });

        $('#table-yearlevel').on('click', '.btn-edit', function() {
            $('#yearlevelid').val($(this).attr('data-yearlevelid'));
            $('#yearlevel').val($(this).attr('data-yearlevel'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateYearLevel.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-yearlevel').serializeArray(),
                success: function(result) {
                    getAllYearLevel();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllYearLevel();

        function getAllYearLevel() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllYearLevel.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    yearlevelData = result.data;

                    if (tableYearLevel !== null) {
                        tableYearLevel.destroy();
                    }

                    yearlevelData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.YearLevelId + `</td>
                                    <td>` + row.YearLevel + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-yearlevelid="` + row.YearLevelId + `"
                                            data-yearlevel="` + row.YearLevel + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-yearlevel tbody').html(html);
                    tableYearLevel = $('#table-yearlevel').DataTable();
                }
            });
        }

        function clearForm() {
            $('#yearlevelid').val('');
            $('#yearlevel').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>