<?php require_once '../common/header-admin.php'; ?>

<form id="form-question">
    <input type="text" id="questionid" name="questionid" placeholder="questionid">
    <input type="text" id="question" name="question" placeholder="question">
</form>

<table id="table-question">
    <thead>
        <tr>
            <th>QuestionId</th>
            <th>Question</th>
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
                                            class="btn-edit"
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