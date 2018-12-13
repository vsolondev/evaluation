<?php require_once '../common/header-admin.php'; ?>

<form id="form-section">
    <input type="text" id="sectionid" name="sectionid" placeholder="sectionid">
    <input type="text" id="sectionname" name="sectionname" placeholder="sectionname">
</form>

<table id="table-section">
    <thead>
        <tr>
            <th>SectionId</th>
            <th>SectionName</th>
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
        var sectionData = [];
        var tableSection = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addSection.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-section').serializeArray(),
                success: function(result) {
                    getAllSection();
                    clearForm();
                }
            });
        });

        $('#table-section').on('click', '.btn-edit', function() {
            $('#sectionid').val($(this).attr('data-sectionid'));
            $('#sectionname').val($(this).attr('data-sectionname'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateSection.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-section').serializeArray(),
                success: function(result) {
                    getAllSection();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllSection();

        function getAllSection() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSection.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    sectionData = result.data;

                    if (tableSection !== null) {
                        tableSection.destroy();
                    }

                    sectionData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SectionId + `</td>
                                    <td>` + row.SectionName + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-sectionid="` + row.SectionId + `"
                                            data-sectionname="` + row.SectionName + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-section tbody').html(html);
                    tableSection = $('#table-section').DataTable();
                }
            });
        }

        function clearForm() {
            $('#sectionid').val('');
            $('#sectionname').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>