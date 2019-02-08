<?php require_once '../common/header-student.php'; ?>
<?php session_start(); ?>

<?php echo $_SESSION['studentid']; ?>

<button type="button" id="btn-start-evaluation">Start Evaluation</button>

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