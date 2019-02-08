<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-schedule label {
        display: inline-block;
        width: 120px;
    }

    #form-schedule input,
    #form-schedule select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }

    input[type="time"] {
        border: 1px solid rgb(169, 169, 169);
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-schedule">
                <input type="text" id="scheduleid" name="scheduleid" placeholder="scheduleid" hidden>

                <label for="scheduleday">Schedule Day: </label>
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
                <br>
                <label for="scheduletimefrom">Time From:</label>
                <input type="time" id="scheduletimefrom" name="scheduletimefrom" placeholder="scheduletimefrom">
                <br>
                <label for="scheduletimeto">Time To:</label>
                <input type="time" id="scheduletimeto" name="scheduletimeto" placeholder="scheduletimeto">
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
                <table id="table-schedule" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


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
                                            class="btn-edit btn btn-primary btn-sm"
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