<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-evaluationschedule label {
        display: inline-block;
        width: 120px;
    }

    #form-evaluationschedule input,
    #form-evaluationschedule select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }

    input[type="date"] {
        border: 1px solid rgb(169, 169, 169);
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-evaluationschedule">
                <input type="text" id="evaluationscheduleid" name="evaluationscheduleid" placeholder="evaluationscheduleid" hidden>

                <label for="scheduledatefrom">Date From: </label>
                <input type="date" id="scheduledatefrom" name="scheduledatefrom">
                <br>
                <label for="scheduledateto">Date To: </label>
                <input type="date" id="scheduledateto" name="scheduledateto">
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
                <table id="table-evaluationschedule" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


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
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-evaluationscheduleid="` + row.EvaluationScheduleId + `"
                                            data-scheduledatefrom="` + row.ScheduleDateFrom + `"
                                            data-scheduledateto="` + row.ScheduleDateTo + `"
                                        >Edit</button>
                                       ` + generateActivateButton(row) + `
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

        function generateActivateButton(row) {
            if (row.IsActive === "0") {
                return `<button 
                    class="btn-activate btn btn-secondary btn-sm"
                    data-evaluationscheduleid="` + row.EvaluationScheduleId + `"
                >Activate</button>`
            }
            
            return ``;
        }

        $(document).on('click', '.btn-activate', function() {
            $.ajax({
                url: '<?php echo base_url('queries/activateEvaluationSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'evaluationscheduleid', value : $(this).attr('data-evaluationscheduleid') }],
                success: function(result) {
                    getAllEvaluationSchedule();
                }
            });
        });
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>