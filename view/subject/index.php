<?php require_once '../common/header-admin.php'; ?>

<form id="form-subject">
    <input type="text" id="subjectid" name="subjectid" placeholder="subjectid">
    <input type="text" id="subjectname" name="subjectname" placeholder="subjectname">
    <input type="text" id="subjectacronym" name="subjectacronym" placeholder="subjectacronym">
</form>

<table id="table-subject">
    <thead>
        <tr>
            <th>SubjectId</th>
            <th>SubjectName</th>
            <th>SubjectAcronym</th>
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
        var subjectData = [];
        var tableSubject = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-subject').serializeArray(),
                success: function(result) {
                    getAllSubject();
                    clearForm();
                }
            });
        });

        $('#table-subject').on('click', '.btn-edit', function() {
            $('#subjectid').val($(this).attr('data-subjectid'));
            $('#subjectname').val($(this).attr('data-subjectname'));
            $('#subjectacronym').val($(this).attr('data-subjectacronym'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-subject').serializeArray(),
                success: function(result) {
                    getAllSubject();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllSubject();

        function getAllSubject() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    subjectData = result.data;

                    if (tableSubject !== null) {
                        tableSubject.destroy();
                    }

                    subjectData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SubjectId + `</td>
                                    <td>` + row.SubjectName + `</td>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-subjectid="` + row.SubjectId + `"
                                            data-subjectname="` + row.SubjectName + `"
                                            data-subjectacronym="` + row.SubjectAcronym + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-subject tbody').html(html);
                    tableSubject = $('#table-subject').DataTable();
                }
            });
        }

        function clearForm() {
            $('#subjectid').val($(this).attr(''));
            $('#subjectname').val($(this).attr(''));
            $('#subjectacronym').val($(this).attr(''));
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>