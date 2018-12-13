<?php require_once '../common/header-admin.php'; ?>

<form id="form-schedule">
    <input type="text" id="scheduleid" name="scheduleid" placeholder="scheduleid">
    <input type="date" id="scheduledatefrom" name="scheduledatefrom" placeholder="scheduledatefrom">
    <input type="time" id="scheduletimefrom" name="scheduletimefrom" placeholder="scheduletimefrom">
    <input type="date" id="scheduledateto" name="scheduledateto" placeholder="scheduledateto">
    <input type="time" id="scheduletimeto" name="scheduletimeto" placeholder="scheduletimeto">
</form>

<table id="table-schedule">
    <thead>
        <tr>
            <th>ScheduleId</th>
            <th>ScheduleDateFrom</th>
            <th>ScheduleTimeFrom</th>
            <th>ScheduleDateTo</th>
            <th>ScheduleTimeTo</th>
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
        var scheduleData = [];
        var tableSchedule = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-schedule').serializeArray(),
                success: function(result) {
                    getAllSchedule();
                    clearForm();
                }
            });
        });

        $('#table-schedule').on('click', '.btn-edit', function() {
            $('#scheduleid').val($(this).attr('data-scheduleid'));
            $('#scheduledatefrom').val($(this).attr('data-scheduledatefrom'));
            $('#scheduletimefrom').val($(this).attr('data-scheduletimefrom'));
            $('#scheduledateto').val($(this).attr('data-scheduledateto'));
            $('#scheduletimeto').val($(this).attr('data-scheduletimeto'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-schedule').serializeArray(),
                success: function(result) {
                    getAllSchedule();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllSchedule();

        function getAllSchedule() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    scheduleData = result.data;

                    if (tableSchedule !== null) {
                        tableSchedule.destroy();
                    }

                    scheduleData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.ScheduleId + `</td>
                                    <td>` + row.ScheduleDateFrom + `</td>
                                    <td>` + row.ScheduleTimeFrom + `</td>
                                    <td>` + row.ScheduleDateTo + `</td>
                                    <td>` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-scheduleid="` + row.ScheduleId + `"
                                            data-scheduledatefrom="` + row.ScheduleDateFrom + `"
                                            data-scheduletimefrom="` + row.ScheduleTimeFrom + `"
                                            data-scheduledateto="` + row.ScheduleDateTo + `"
                                            data-scheduletimeto="` + row.ScheduleTimeTo + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-schedule tbody').html(html);
                    tableSchedule = $('#table-schedule').DataTable();
                }
            });
        }

        function clearForm() {
            $('#scheduleid').val('');
            $('#scheduledatefrom').val('');
            $('#scheduletimefrom').val('');
            $('#scheduledateto').val('');
            $('#scheduletimeto').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>