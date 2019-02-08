<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-section label {
        display: inline-block;
        width: 120px;
    }

    #form-section input,
    #form-section select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }

    #form-section-subject label {
        display: inline-block;
        width: 120px;
    }

    #form-section-subject input,
    #form-section-subject select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-section">
                <input type="text" id="sectionid" name="sectionid" placeholder="sectionid" hidden>

                <label for="sectionname">Section: </label>
                <input type="text" id="sectionname" name="sectionname" placeholder="sectionname">
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
                <table id="table-section" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>SectionId</th>
                            <th>SectionName</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



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
        <div class="row">
            <div class="col-12 col-md-6">
                <form id="form-section-subject">
                    <input type="text" id="sectionsubjectscheduleid" name="sectionsubjectscheduleid" placeholder="sectionsubjectscheduleid" hidden>
                    <input type="text" id="sectionid" name="sectionid" placeholder="sectionid" hidden>

                    <label for="subjectid">Subject: </label>
                    <select id="subjectid" name="subjectid"></select>
                    <br>
                    <label for="scheduleid">Schedule: </label>
                    <select id="scheduleid" name="scheduleid"></select>
                </form>
            </div>

            <div class="col-12 col-md-6">
                <button id="btn-add-section-subject" class="btn btn-primary btn-sm">Add</button>
                <button id="btn-update-section-subject" class="btn btn-secondary btn-sm">Update</button>  
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="table-section-subject" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
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
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-sectionid="` + row.SectionId + `"
                                            data-sectionname="` + row.SectionName + `"
                                        >Edit</button>
                                        <button 
                                            type="button" 
                                            class="btn-addsubjects btn btn-secondary btn-sm"
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
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-sectionsubjectscheduleid="` + row.SectionSubjectScheduleId + `"
                                            data-subjectid="` + row.SubjectId + `"
                                            data-scheduleid="` + row.ScheduleId + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-delete btn btn-secondary btn-sm"
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