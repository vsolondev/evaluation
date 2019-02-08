<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-question label {
        display: inline-block;
        width: 120px;
    }

    #form-question input,
    #form-question select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-question">
                <input type="text" id="questionid" name="questionid" placeholder="questionid" hidden>

                <label for="question">Question: </label>
                <input type="text" id="question" name="question" placeholder="question">
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
                <table id="table-question" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>QuestionId</th>
                            <th>Question</th>
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
        var questionData = [];
        var tableQuestion = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addQuestion.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-question').serializeArray(),
                success: function(result) {
                    getAllQuestion();
                    clearForm();
                }
            });
        });

        $('#table-question').on('click', '.btn-edit', function() {
            $('#questionid').val($(this).attr('data-questionid'));
            $('#question').val($(this).attr('data-question'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateQuestion.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-question').serializeArray(),
                success: function(result) {
                    getAllQuestion();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllQuestion();

        function getAllQuestion() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllQuestion.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    questionData = result.data;

                    if (tableQuestion !== null) {
                        tableQuestion.destroy();
                    }

                    questionData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.QuestionId + `</td>
                                    <td>` + row.Question + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-questionid="` + row.QuestionId + `"
                                            data-question="` + row.Question + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-question tbody').html(html);
                    tableQuestion = $('#table-question').DataTable();
                }
            });
        }

        function clearForm() {
            $('#questionid').val('');
            $('#question').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>