<?php require_once '../common/header-admin.php'; ?>

<form id="form-evaluationschedule">
    <input type="text" id="evaluationscheduleid" name="evaluationscheduleid" placeholder="evaluationscheduleid">
    <input type="date" id="scheduledatefrom" name="scheduledatefrom">
    <input type="date" id="scheduledateto" name="scheduledateto">
</form>

<table id="table-evaluationschedule">
    <thead>
        <tr>
            <th>EvaluationScheduleId</th>
            <th>ScheduleDateFrom</th>
            <th>ScheduleDateTo</th>
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
        var evaluationScheduleData = [];
        var tableEvaluationSchedule = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addEvaluationSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-evaluationschedule').serializeArray(),
                success: function(result) {
                    getAllEvaluationSchedule();
                    clearForm();
                }
            });
        });

        $('#table-evaluationschedule').on('click', '.btn-edit', function() {
            $('#evaluationscheduleid').val($(this).attr('data-evaluationscheduleid'));
            $('#scheduledatefrom').val($(this).attr('data-scheduledatefrom'));
            $('#scheduledateto').val($(this).attr('data-scheduledateto'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateEvaluationSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-evaluationschedule').serializeArray(),
                success: function(result) {
                    getAllEvaluationSchedule();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllEvaluationSchedule();

        function getAllEvaluationSchedule() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllEvaluationSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    evaluationScheduleData = result.data;

                    if (tableEvaluationSchedule !== null) {
                        tableEvaluationSchedule.destroy();
                    }

                    evaluationScheduleData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.EvaluationScheduleId + `</td>
                                    <td>` + row.ScheduleDateFrom + `</td>
                                    <td>` + row.ScheduleDateTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-evaluationscheduleid="` + row.EvaluationScheduleId + `"
                                            data-scheduledatefrom="` + row.ScheduleDateFrom + `"
                                            data-scheduledateto="` + row.ScheduleDateTo + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-evaluationschedule tbody').html(html);
                    tableEvaluationSchedule = $('#table-evaluationschedule').DataTable();
                }
            });
        }

        function clearForm() {
            $('#evaluationscheduleid').val('');
            $('#scheduledatefrom').val('');
            $('#scheduledateto').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>