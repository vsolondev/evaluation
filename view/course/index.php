<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-course label {
        display: inline-block;
        width: 150px;
    }

    #form-course input,
    #form-course select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-course">
                <input type="text" id="courseid" name="courseid" placeholder="courseid" hidden>

                <label for="coursename">Course Name: </label>
                <input type="text" id="coursename" name="coursename" placeholder="coursename">
                <br>
                <label for="courseacronym">Course Acronym: </label>
                <input type="text" id="courseacronym" name="courseacronym" placeholder="courseacronym">
            </form>
        </div>
        
        <div class="col-12 col-md-6">
            <br>
            <br>
            <button type="button" id="btn-add" class="btn btn-primary btn-sm">Add</button>
            <button type="button" id="btn-update" class="btn btn-secondary btn-sm">Update</button>
            <button type="button" id="btn-cancel" class="btn btn-white btn-sm">Cancel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-course" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>CourseId</th>
                            <th>CourseName</th>
                            <th>CourseAcronym</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var courseData = [];
        var tableCourse = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addCourse.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-course').serializeArray(),
                success: function(result) {
                    getAllCourse();
                    clearForm();
                }
            });
        });

        $('#table-course').on('click', '.btn-edit', function() {
            $('#courseid').val($(this).attr('data-courseid'));
            $('#coursename').val($(this).attr('data-coursename'));
            $('#courseacronym').val($(this).attr('data-courseacronym'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateCourse.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-course').serializeArray(),
                success: function(result) {
                    getAllCourse();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllCourse();

        function getAllCourse() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllCourse.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    courseData = result.data;

                    if (tableCourse !== null) {
                        tableCourse.destroy();
                    }

                    courseData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.CourseId + `</td>
                                    <td>` + row.CourseName + `</td>
                                    <td>` + row.CourseAcronym + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit btn btn-primary btn-sm"
                                            data-courseid="` + row.CourseId + `"
                                            data-coursename="` + row.CourseName + `"
                                            data-courseacronym="` + row.CourseAcronym + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-course tbody').html(html);
                    tableCourse = $('#table-course').DataTable();
                }
            });
        }

        function clearForm() {
            $('#courseid').val($(this).attr(''));
            $('#coursename').val($(this).attr(''));
            $('#courseacronym').val($(this).attr(''));
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>