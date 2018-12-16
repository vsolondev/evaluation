<?php require_once '../common/header-admin.php'; ?>

<form id="form-schedule">
    <input type="text" id="scheduleid" name="scheduleid" placeholder="scheduleid">
    <select id="scheduleday" name="scheduleday">
        <option value="Monday To Friday">Monday To Friday</option>
        <option value="Monday, Wednesday, Friday">Monday, Wednesday, Friday</option>
        <option value="Tuesday, Thursday">Tuesday, Thursday</option>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
        <option value="Saturday">Saturday</option>
    </select>
    <input type="time" id="scheduletimefrom" name="scheduletimefrom" placeholder="scheduletimefrom">
    <input type="time" id="scheduletimeto" name="scheduletimeto" placeholder="scheduletimeto">
</form>

<table id="table-schedule">
    <thead>
        <tr>
            <th>ScheduleId</th>
            <th>ScheduleDay</th>
            <th>ScheduleTimeFrom</th>
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
            $('#scheduleday').val($(this).attr('data-scheduleday'));
            $('#scheduletimefrom').val($(this).attr('data-scheduletimefrom'));
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
                                    <td>` + row.ScheduleDay + `</td>
                                    <td>` + row.ScheduleTimeFrom + `</td>
                                    <td>` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-scheduleid="` + row.ScheduleId + `"
                                            data-scheduleday="` + row.ScheduleDay + `"
                                            data-scheduletimefrom="` + row.ScheduleTimeFrom + `"
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
            $('#scheduleday').val('Monday');
            $('#scheduletimefrom').val('');
            $('#scheduletimeto').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>