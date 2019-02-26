<?php require_once '../common/header-student.php'; ?>
<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>

<style>
    #teachers-evaluation-form {
        overflow: auto;
    }

    .teacher-box {
        float: left;
        text-align: center;
        margin: 1rem;
        width: 250px;
    }

    textarea {
        width: 100%;
        height: 300px;
    }

    .teacher-image {
        width: 150px;
        height: auto;
        min-height: 150px;
        border: 1px solid;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-4">Teacher Evaluation Comment</h5>
            <form id="teachers-evaluation-form" class="d-flex justify-content-center"></form>
            
            <div class="text-center">
                <a href="<?php echo base_url('view/evaluation/index.php?questionid=1'); ?>" class="btn btn-secondary">Back to Evaluation</a>
                <button type="button" id="btn-save" class="btn btn-primary">Save Comments</button>
            </div>
        </div>
    </div>
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
                                    <img src="#" id="teacher-image-` + row.AccountId + `" class="teacher-image">
                                    <h6 class="mb-3">` + row.FirstName + ` ` + row.MiddleName + ` ` + row.LastName + `</h6>
                                    <p class="mb-0">` + row.ScheduleDay + `</p>
                                    <p class="mb-0">` + row.ScheduleTimeFrom + ` - ` + row.ScheduleTimeTo + `</p>
                                    <p class="mb-0">` + row.SectionName + `</p>
                                    <div class="comment-box mt-3">
                                        <h6>Good Comment</h6>
                                        <textarea id="good-comment-` + row.EvaluationId + `">` + row.GoodComment + `</textarea>
                                        <br />
                                        <h6>Bad Comment</h6>
                                        <textarea id="bad-comment-` + row.EvaluationId + `">` + row.BadComment + `</textarea>
                                    </div>
                                </div>`;
                    });

                    $('#teachers-evaluation-form').html(html);

                    teachersData.forEach(function(row) {
                        // At the same time get teacher's image
                        getImageByAccountId(row.AccountId);
                    });
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

        function getImageByAccountId(accountId) {
            $.ajax({
                url: '<?php echo base_url('queries/getImageByAccountId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'accountid' , value : accountId }],
                success: function(result) {
                    $('#teacher-image-' + accountId).attr('src', result.image);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-student.php'; ?>