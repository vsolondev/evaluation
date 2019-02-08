<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-subject label {
        display: inline-block;
        width: 150px;
    }

    #form-subject input,
    #form-subject select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-subject">
                <input type="text" id="subjectid" name="subjectid" placeholder="subjectid" hidden>
                
                <label for="subjectname">Subject Name: </label>
                <input type="text" id="subjectname" name="subjectname" placeholder="subjectname">
                <br>
                <label for="subjectacronym">Subject Acronym: </label>
                <input type="text" id="subjectacronym" name="subjectacronym" placeholder="subjectacronym">
            </form>
        </div>

        <div class="col-12 col-md-6">
            <br>
            <br>
            <button type="button" id="btn-add" class="btn btn-primary btn-sm">Add</button>
            <button type="button" id="btn-update" class="btn btn-secondary btn-sm">Update</button>
            <button type="button" id="btn-cancel" class="btn btn-white btn-sm">Cancel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-subject" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


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
                                            class="btn-edit btn btn-primary btn-sm"
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