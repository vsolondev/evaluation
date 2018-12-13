<?php require_once '../common/header-admin.php'; ?>

<form id="form-course">
    <input type="text" id="courseid" name="courseid" placeholder="courseid">
    <input type="text" id="coursename" name="coursename" placeholder="coursename">
    <input type="text" id="courseacronym" name="courseacronym" placeholder="courseacronym">
</form>

<table id="table-course">
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

<button type="button" id="btn-add">Add</button>
<button type="button" id="btn-update">Update</button>
<button type="button" id="btn-cancel">Cancel</button>

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
                                            class="btn-edit"
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