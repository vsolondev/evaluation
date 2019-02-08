<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-yearlevel label {
        display: inline-block;
        width: 120px;
    }

    #form-yearlevel input,
    #form-yearlevel select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-yearlevel">
                <input type="text" id="yearlevelid" name="yearlevelid" placeholder="yearlevelid" hidden>

                <label for="yearlevel">Year Level: </label>
                <input type="text" id="yearlevel" name="yearlevel" placeholder="yearlevel">
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
                <table id="table-yearlevel" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>YearLevelId</th>
                            <th>YearLevel</th>
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
                                            class="btn-edit btn btn-primary btn-sm"
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