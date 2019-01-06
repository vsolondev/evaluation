<?php require_once '../common/header-admin.php'; ?>

<style>
    #subjects-wrapper {
        overflow: auto;
    }

    .subject-box {
        float: left;
        text-align: center;
        margin: 1rem;
    }
</style>

<h6 class="text-center">Teacher Evaluation Result By Subjects Handled</h6>

<h6 id="teacher-wrapper" class="text-center"></h6>
<div id="subjects-wrapper" class="d-flex justify-content-center">
</div>

<script>
    $(document).ready(function() {
        var teacherId = getParameterByName('teacherid');

        getTeacherByTeacherId();
        getAllAssignedSubjectsByTeacherId();

        function getTeacherByTeacherId() {
            $.ajax({
                url: '<?php echo base_url('queries/getTeacherByTeacherId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'teacherid', value : teacherId }],
                success: function(result) {
                    var html = ``;
                    var teacherData = result.data;

                    html += teacherData.LastName + `, ` + teacherData.FirstName + ` ` + teacherData.MiddleName;

                    $('#teacher-wrapper').html(html);
                }
            });
        }

        function getAllAssignedSubjectsByTeacherId() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllAssignedSubjectsByTeacherId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'teacherid', value : teacherId }],
                success: function(result) {
                    var html = ``;
                    var assignedSubjectsData = result.data;

                    assignedSubjectsData.forEach(function(row, i) {
                        getAllStudentSSSBySectionSubjectScheduleId(row.SectionSubjectScheduleId, function(studentSSSData) {
                            var totalStudents = studentSSSData.length;
                            
                            getTeacherScoreFromStudents(studentSSSData, function(teacherScore) {
                                getMaximumScore(totalStudents, function(maximumScore) {
                                    html += `<div class="subject-box">
                                                <h6>` + row.SectionName + `</h6>
                                                <h6>` + row.SubjectAcronym + `</h6>
                                                <h6>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</h6>
                                                <h6>` + teacherScore + ` / ` + maximumScore + `</h6>
                                                <h6>` + (teacherScore / maximumScore).toFixed(2) + `% over 100%</h6>
                                                <a 
                                                    class="btn btn-primary"
                                                    href="` + '<?php echo base_url("view/report/evaluation_result_detail.php?sectionsubjectscheduleid=' + row.SectionSubjectScheduleId + '"); ?>' + `"
                                                >More Details</a>
                                            </div>`;

                                    $('#subjects-wrapper').html(html);
                                });
                            });
                        });
                    });
                }
            }); 
        }

        function getAllStudentSSSBySectionSubjectScheduleId(sssId, callBack) {
            $.ajax({
                url: '<?php echo base_url('queries/getAllStudentSSSBySectionSubjectScheduleId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'sectionsubjectscheduleid', value : sssId }],
                success: function(result) {
                    var studentSSSData = result.data;
                    callBack(studentSSSData);
                }
            });
        }

        function getTeacherScoreFromStudents(studentSSSData, callBack) {
            $.ajax({
                url: '<?php echo base_url('queries/getTeacherScoreFromStudents.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'studentsssdata', value : JSON.stringify(studentSSSData) },
                    { name : 'teacherid', value : teacherId }
                ],
                success: function(result) {
                    var teacherScore = result.teacherScore;
                    callBack(teacherScore);
                }
            });
        }

        function getMaximumScore(totalStudents, callBack) {
            $.ajax({
                url: '<?php echo base_url('queries/getMaximumScore.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'totalstudents', value : totalStudents }],
                success: function(result) {
                    var maximumScore = result.maximumScore;
                    callBack(maximumScore);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>