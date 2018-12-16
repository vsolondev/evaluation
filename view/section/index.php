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

<div id="modal-add-subjects" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-section-subject">
            <input type="text" id="sectionsubjectscheduleid" name="sectionsubjectscheduleid" placeholder="sectionsubjectscheduleid">
            <input type="text" id="sectionid" name="sectionid" placeholder="sectionid">
            <select id="subjectid" name="subjectid"></select>
            <select id="scheduleid" name="scheduleid"></select>
        </form>
        <button id="btn-add-section-subject">Add</button>
        <button id="btn-update-section-subject">Update</button>

        <table id="table-section-subject">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        var sectionData = [];
        var tableSection = null;
        var tableSectionSubject = null;
        var sectionid = null;
        var modalAddSubject = $('#modal-add-subjects');

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
                                        <button 
                                            type="button" 
                                            class="btn-addsubjects"
                                            data-toggle="modal" 
                                            data-sectionid="` + row.SectionId + `"
                                        >Add Subjects</button>
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

        $('#table-section tbody').on('click', '.btn-addsubjects', function() {
            sectionid = $(this).attr('data-sectionid');
            
            modalAddSubject.find('#sectionid').val(sectionid);
            modalAddSubject.modal('show');

            getAllSectionSubjectScheduleBySectionId();
        });

        function getAllSectionSubjectScheduleBySectionId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSectionSubjectScheduleBySectionId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'sectionid', value : sectionid }],
                success: function(result) {
                    var html = ``;
                    var sectionSubjectData = result.data;

                    if (tableSectionSubject !== null) {
                        tableSectionSubject.destroy();
                    }

                    sectionSubjectData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.SubjectAcronym + `</td>
                                    <td>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                            data-subjectid="` + row.SubjectId + `"
                                            data-scheduleid="` + row.ScheduleId + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-delete"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                        >Delete</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-section-subject tbody').html(html);
                    tableSectionSubject = $('#table-section-subject').DataTable();
                }
            });
        }

        getAllSubject();

        function getAllSubject() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSubject.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var subjectData = result.data;

                    subjectData.forEach(function(row, i) {
                        html += `<option value="` + row.SubjectId + `">` + row.SubjectAcronym + `</option>`;
                    });

                    $('#subjectid').html(html);
                }
            });
        }

        getAllSchedule();

        function getAllSchedule() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    var scheduleData = result.data;

                    scheduleData.forEach(function(row, i) {
                        html += `<option value="` + row.ScheduleId + `">` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</option>`;
                    });

                    $('#scheduleid').html(html);
                }
            });
        }

        modalAddSubject.find('#btn-add-section-subject').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addSectionSubjectSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-section-subject').serializeArray(),
                success: function(result) {
                    getAllSectionSubjectScheduleBySectionId();
                    clearForm2();
                }
            });
        });

        modalAddSubject.on('click', '.btn-edit', function() {
            modalAddSubject.find('#sectionsubjectscheduleid').val($(this).attr('data-sectionsubjectscheduleid'));
            modalAddSubject.find('#subjectid').val($(this).attr('data-subjectid'));
            modalAddSubject.find('#scheduleid').val($(this).attr('data-scheduleid'));
        });

        modalAddSubject.find('#btn-update-section-subject').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateSectionSubjectSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-section-subject').serializeArray(),
                success: function(result) {
                    getAllSectionSubjectScheduleBySectionId();
                    clearForm2();
                }
            });
        });

        modalAddSubject.on('click', '.btn-delete', function() {
            var sectionsubjectscheduleid = $(this).attr('data-sectionsubjectscheduleid');

            $.ajax({
                url: '<?php echo base_url('queries/deleteSectionSubjectSchedule.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'sectionsubjectscheduleid', value : sectionsubjectscheduleid }],
                success: function(result) {
                    getAllSectionSubjectScheduleBySectionId();
                    clearForm2();
                }
            });
        });

        function clearForm2() {
            modalAddSubject.find('#sectionsubjectscheduleid').val('');
            modalAddSubject.find('#sectionid').val(sectionid);
            modalAddSubject.find('#subjectid').val('');
            modalAddSubject.find('#scheduleid').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>