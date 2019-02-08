<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-rating label {
        display: inline-block;
        width: 150px;
    }

    #form-rating input,
    #form-rating select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row mt-4 mb-5">
        <div class="col-12 col-md-6">
            <form id="form-rating">
                <input type="text" id="ratingid" name="ratingid" placeholder="ratingid" hidden>

                <label for="ratingdescription">Rating Description: </label>
                <input type="text" id="ratingdescription" name="ratingdescription" placeholder="ratingdescription">
                <br>
                <label for="ratingvalue">Rating Value: </label>
                <input type="text" id="ratingvalue" name="ratingvalue" placeholder="ratingvalue">
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
                <table id="table-rating" class="table table-striped table-sm table-borderless nowrap">
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
            </div>
        </div>
    </div>
</div>


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
                                            class="btn-edit btn btn-primary btn-sm"
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