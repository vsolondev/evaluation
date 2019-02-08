<?php require_once '../common/header-student.php'; ?>
<?php session_start(); ?>

<style>
    #teachers-evaluation-form {
        overflow: auto;
    }

    .teacher-box {
        float: left;
        text-align: center;
        margin: 1rem;
    }

    textarea {
        width: 100%;
        height: 300px;
    }
</style>

<?php echo $_SESSION['studentid']; ?>

<h6 class="text-center">Comment</h6>
<form id="teachers-evaluation-form" class="d-flex justify-content-center"></form>

<div class="text-center">
    <button type="button" id="btn-save">Save</button>
</div>

<script>
    $(document).ready(function() {
        getAllTeachersOfStudent();

        function getAllTeachersOfStudent() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllTeachersOfStudent.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var teachersData = result.data;
                    var html = ``;

                    teachersData.forEach(function(row) {
                        html += `<div 
                                    class="teacher-box"
                                    data-evaluationid="` + row.EvaluationId + `"
                                    data-teacherid="` + row.TeacherId + `"
                                >
                                    <img alt="teacher-image" />
                                    <h6>` + row.LastName + `, ` + row.FirstName + ` ` + row.MiddleName + `</h6>
                                    <p>` + row.ScheduleDay + ` ` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</p>
                                    <p>` + row.SectionName + `</p>
                                    <div class="comment-box">
                                        <h6>Good Comment</h6>
                                        <textarea id="good-comment-` + row.EvaluationId + `">` + row.GoodComment + `</textarea>
                                        <br />
                                        <h6>Bad Comment</h6>
                                        <textarea id="bad-comment-` + row.EvaluationId + `">` + row.BadComment + `</textarea>
                                    </div>
                                </div>`;
                    });

                    $('#teachers-evaluation-form').html(html);
                }
            });
        }

        $('#btn-save').click(function() {
            var data = [];
            var hasEmpty = false;
            
            $('.teacher-box').each(function() {
                var evaluationId = parseInt($(this).attr('data-evaluationid'));
                var goodComment = $('#good-comment-' + evaluationId).val();
                var badComment = $('#bad-comment-' + evaluationId).val();

                if (goodComment !== '' && badComment !== '') {
                    data.push({
                        'evaluationid': evaluationId,
                        'goodcomment': goodComment,
                        'badcomment': badComment
                    });
                } else {
                    hasEmpty = true;
                }
            });

            if (hasEmpty === false) {
                saveStudentTeacherComment(data);
            }
        });

        function saveStudentTeacherComment(data) {
            $.ajax({
                url: '<?php echo base_url('queries/saveStudentTeacherComment.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'data', value : JSON.stringify(data) }],
                success: function(result) {
                    var success = result.success;

                    if (success) {
                        alert('Success!');
                    }
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-student.php'; ?>