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

    #btn-save {
        display: none;
    }
</style>

<?php echo $_SESSION['studentid']; ?>

<h5 id="question" class="text-center"></h5>
<form id="teachers-evaluation-form" class="d-flex justify-content-center"></form>

<div class="text-center">
    <button type="button" id="btn-previous">Previous</button>
    <button type="button" id="btn-next">Next</button>
    <button type="button" id="btn-save">Save</button>
</div>

<script>
    $(document).ready(function() {
        var ratingData = [];
        var questionId = 0;
        
        getAllRating();

        function getAllRating() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    ratingData = result.data;
                    getQuestion();
                }
            });
        }

        function getQuestion() {
            $.ajax({
                url: '<?php echo base_url('queries/getQuestionByQuestionId.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'questionid', value : getParameterByName('questionid') }],
                success: function(result) {
                    var questionData = result.data;

                    $('#question').text(questionData.Question);
                    questionId = parseInt(questionData.QuestionId);
                    getAllTeachersOfStudent();

                    disableNextOrPreviousButton(true);
                    disableNextOrPreviousButton(false);
                }
            });
        }

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
                                    <div class="rating-box">
                                        `+ generateRatingRadioButtons(row.EvaluationId) +`
                                    </div>
                                </div>`;
                    });

                    $('#teachers-evaluation-form').html(html);

                    // Check one of radio button if there is already a value
                    teachersData.forEach(function(row) {
                        getStudentTeacherRating(row.EvaluationId);
                    });
                }
            });
        }

        function generateRatingRadioButtons(evaluationId) {
            var html = ``;
            ratingData.forEach(function(row) {
                html += `<div>
                            <input 
                                type="radio" 
                                name="rating-` + evaluationId + `" 
                                id="rating-` + evaluationId + `-` + row.RatingId + `" 
                                value="`+ row.RatingValue +`"
                            >
                            <label 
                                for="rating-` + evaluationId + `-` + row.RatingId + `"
                            >` + row.RatingDescription + `</label>
                        </div>`;
            });
            return html;
        }

        function getStudentTeacherRating(evaluationId) {
            $.ajax({
                url: '<?php echo base_url('queries/getStudentTeacherRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [
                    { name : 'evaluationid' , value : evaluationId },
                    { name : 'questionid' , value : questionId }
                ],
                success: function(result) {
                    var strData = result.data;
                    if (strData) {
                        $('#rating-' + evaluationId + '-' + strData.RatingId).prop('checked', true);
                    }
                }
            });
        }

        function disableNextOrPreviousButton(isNext) {
            getNextOrPreviousQuestion(isNext, function(callBackData) {
                if (callBackData === false) {
                    var buttonId = (isNext === true) ? '#btn-next' : '#btn-previous';
                    $(buttonId).attr('disabled', 'disabled');
                    $('#btn-save').show();
                }
            });
        }

        $('#btn-next, #btn-previous, #btn-save').click(function() {
            var buttonId = this.id;
            var data = [];
            var hasNaN = false;
            
            $('.teacher-box').each(function() {
                var evaluationId = parseInt($(this).attr('data-evaluationid'));
                var ratingId = parseInt($('input[name=rating-' + evaluationId + ']:checked').val());

                if (isNaN(ratingId) === false) {
                    data.push({
                        'evaluationid': evaluationId,
                        'questionid': questionId,
                        'ratingid': ratingId
                    });
                } else {
                    hasNaN = true;
                }
            });

            if (hasNaN === false) {
                saveStudentTeacherRating(data, buttonId);
            }
        });

        function saveStudentTeacherRating(data, buttonId) {
            $.ajax({
                url: '<?php echo base_url('queries/saveStudentTeacherRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: [{ name : 'data', value : JSON.stringify(data) }],
                success: function(result) {
                    var success = result.success;

                    if (success) {
                        if (buttonId !== 'btn-save') {
                            var isNext = (buttonId === 'btn-next') ? true : false;

                            getNextOrPreviousQuestion(isNext, function(callBackData) {
                                window.location.href = '<?php echo base_url("view/evaluation?questionid='+callBackData.QuestionId+'"); ?>';
                            });
                        }
                    }
                }
            });
        }

        function getNextOrPreviousQuestion(isNext, callBack) {
            var url = '';

            if (isNext === true) {
                url = '<?php echo base_url('queries/nextQuestion.php'); ?>';
            } else {
                url = '<?php echo base_url('queries/previousQuestion.php'); ?>';
            }

            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: [{ name : 'questionid' , value : questionId }],
                success: function(result) {
                    callBack(result.data);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-student.php'; ?>