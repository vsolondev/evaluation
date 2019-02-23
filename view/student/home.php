<?php require_once '../common/header-student.php'; ?>
<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <h5>Evaluate your teachers performance.</h5>
            <button type="button" id="btn-start-evaluation" class="btn btn-primary">Start Evaluation</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btn-start-evaluation').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/initEvaluation.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    if (result.success === true) {
                        window.location.href = '<?php echo base_url("view/evaluation?questionid='+result.questionId+'"); ?>';
                    }
                }
            });
        });
    });
</script>

<?php require_once '../common/footer-student.php'; ?>