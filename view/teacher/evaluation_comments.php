<?php require_once '../common/header-teacher.php'; ?>

<style>
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div id="teacher-section-wrapper" class="text-center mt-3"></div>
            <br>
            <br>
            <h3>Good Comments</h3>
            <div id="good-comments-wrapper"></div>
            <h3 class="mt-5">Bad Comments</h3>
            <div id="bad-comments-wrapper"></div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        getSSSBySSSId();
        getAllStudentSSSBySectionSubjectScheduleId();

        function getSSSBySSSId() {
            $.ajax({
                url: '<?php echo base_url('queries/getSSSBySSSId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'sssid', value : getParameterByName('sssid') }],
                success: function(result) {
                    var data = result.data;
                    var html = ``;

                    html += `<h6>` + data.SectionName + `</h6>`;
                    html += `<h6>` + data.SubjectAcronym + `</h6>`;
                    html += `<h6>` + data.ScheduleDay + `</h6>`;
                    html += `<h6>` + data.ScheduleTimeFrom + ` - ` + data.ScheduleTimeTo + `</h6>`;

                    $('#teacher-section-wrapper').html(html);
                }
            });
        }

        function getAllStudentSSSBySectionSubjectScheduleId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllStudentSSSBySectionSubjectScheduleId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'sectionsubjectscheduleid', value : getParameterByName('sssid') }],
                success: function(result) {
                    var studentSSSData = result.data;

                    studentSSSData.forEach(function(row) {
                        getEvaluationComments(row.StudentId);
                    });
                }
            });
        }

        function getEvaluationComments(studentId) {
            $.ajax({
                url: '<?php echo base_url('queries/getEvaluationComment.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'studentid', value : studentId }, { name : 'teacherid', value : getParameterByName('teacherid') }],
                success: function(result) {
                    var data = result.data;
                    
                    var goodCommentHtml = `<p>` + data.GoodComment + `</p>`;
                    var badCommentHtml = `<p>` + data.BadComment + `</p>`;

                    $('#good-comments-wrapper').append(goodCommentHtml);
                    $('#bad-comments-wrapper').append(badCommentHtml);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-teacher.php'; ?>