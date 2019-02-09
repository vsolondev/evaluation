<?php require_once '../common/header-admin.php'; ?>

<style>
    #teachers-wrapper {
        overflow: auto;
    }

    .teacher-box {
        float: left;
        text-align: center;
        margin: 1rem;
        width: 250px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mt-4 mb-5">EVALUATION REPORT</h3>

            <h5 class="mb-1 text-center">Lists of Teachers</h5>
            <div id="teachers-wrapper" class="d-flex justify-content-center">
            </div>
        </div>
    </div>
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
                                    <h6>` + row.FirstName + ` ` + row.MiddleName + ` ` + row.LastName + `</h6>
                                    <a 
                                        class="btn btn-primary btn-sm"
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