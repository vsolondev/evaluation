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

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-4">Teacher Evaluation Result By Subjects Handled</h5>
            <h5 id="teacher-wrapper" class="text-center"></h5>

            <div id="subjects-wrapper" class="d-flex justify-content-center">
        </div>
    </div>
</div>

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
                                                <h6>` + row.ScheduleDay + `</h6>
                                                <h6>` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</h6>
                                                <h5>` + teacherScore + ` / ` + maximumScore + ` points</h5>
                                                <h5>` + ((teacherScore / maximumScore) * 100).toFixed(2) + `% over 100%</h5> 
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