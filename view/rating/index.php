<?php require_once '../common/header-admin.php'; ?>

<form id="form-rating">
    <input type="text" id="ratingid" name="ratingid" placeholder="ratingid">
    <input type="text" id="ratingdescription" name="ratingdescription" placeholder="ratingdescription">
    <input type="text" id="ratingvalue" name="ratingvalue" placeholder="ratingvalue">
</form>

<table id="table-rating">
    <thead>
        <tr>
            <th>RatingId</th>
            <th>RatingDescription</th>
            <th>RatingValue</th>
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
        var ratingData = [];
        var tableRating = null;

        $('#btn-add').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/addRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-rating').serializeArray(),
                success: function(result) {
                    getAllRating();
                    clearForm();
                }
            });
        });

        $('#table-rating').on('click', '.btn-edit', function() {
            $('#ratingid').val($(this).attr('data-ratingid'));
            $('#ratingdescription').val($(this).attr('data-ratingdescription'));
            $('#ratingvalue').val($(this).attr('data-ratingvalue'));
        });

        $('#btn-update').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-rating').serializeArray(),
                success: function(result) {
                    getAllRating();
                    clearForm();
                }
            });
        });

        $('#btn-cancel').click(clearForm);

        getAllRating();

        function getAllRating() {
            $.ajax({
                url: '<?php echo base_url('queries/getAllRating.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var html = ``;
                    ratingData = result.data;

                    if (tableRating !== null) {
                        tableRating.destroy();
                    }

                    ratingData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.RatingId + `</td>
                                    <td>` + row.RatingDescription + `</td>
                                    <td>` + row.RatingValue + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-ratingid="` + row.RatingId + `"
                                            data-ratingdescription="` + row.RatingDescription + `"
                                            data-ratingvalue="` + row.RatingValue + `"
                                        >Edit</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-rating tbody').html(html);
                    tableRating = $('#table-rating').DataTable();
                }
            });
        }

        function clearForm() {
            $('#ratingid').val('');
            $('#ratingdescription').val('');
            $('#ratingvalue').val('');
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>