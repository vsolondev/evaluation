<?php require_once '../common/header-admin.php'; ?>

<style>
    #teachers-wrapper {
        overflow: auto;
    }

    .teacher-box {
        float: left;
        text-align: center;
        margin: 1rem;
    }
</style>

<h6 class="text-center">REPORT</h6>

<div id="teachers-wrapper" class="d-flex justify-content-center">
</div>

<script>
    $(document).ready(function() {
        getAllTeacher();

        function getAllTeacher() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllTeacher.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    teacherData = result.data;

                    teacherData.forEach(function(row) {
                        html += `<div 
                                    class="teacher-box"
                                >
                                    <img alt="teacher-image" />
                                    <h6>` + row.LastName + `, ` + row.FirstName + ` ` + row.MiddleName + `</h6>
                                    <a 
                                        class="btn btn-primary"
                                        href="` + '<?php echo base_url("view/report/evaluation_result.php?teacherid=' + row.TeacherId + '"); ?>' + `"
                                    >View Evaluation Results</a>
                                </div>`;
                    });

                    $('#teachers-wrapper').html(html);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>