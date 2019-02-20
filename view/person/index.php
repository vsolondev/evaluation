<?php require_once '../common/header-admin.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
        
            <form id="form-person">
                <h4>Enter Person</h4>
                <br>
                <input type="text" id="personid" name="personid" placeholder="personid">
                <input type="text" id="firstname" name="firstname" placeholder="firstname">
                <input type="text" id="lastname" name="lastname" placeholder="lastname">
                <input type="number" id="age" name="age" placeholder="age">
            </form>

            <br>

            <button id="btn-add">Add</button>
            <button id="btn-update">Update</button>
            <button id="btn-clear">Clear</button>

        </div>
    </div>

    <br>
    <br>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="table-person" class="table table-striped table-sm table-borderless nowrap">
                    <thead>
                        <tr>
                            <th>PersonId</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Age</th>
                            <th>Actions</th>
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
        var tablePerson = null;

        // This function will be executed after the page was loaded
        getAllPersons();

        // Add event on #btn-add
        $('#btn-add').click(function() {
            
            // Connect to database thru AJAX
            $.ajax({
                url: '<?php echo base_url('queries/addPerson.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-person').serializeArray(),
                success: function(result) {
                    // If query is success execute here
                    getAllPersons();
                    ClearForm();
                }
            });
        });

        // Created this function because of duplication / code reusability
        function getAllPersons() {
            $.ajax({
                url: '<?php echo base_url('queries/getPersons.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    // If query is success execute here
                    
                    var html = ``;
                    var personData = result.data;

                    if (tablePerson !== null) {
                        tablePerson.destroy();
                    }

                    // Loop all the person data and create html
                    personData.forEach(function(row, i) {
                        html += `<tr>
                                    <td>` + row.PersonId + `</td>
                                    <td>` + row.FirstName + `</td>
                                    <td>` + row.LastName + `</td>
                                    <td>` + row.Age + `</td>
                                    <td>
                                        <button 
                                            class="btn-edit"
                                            data-personid="` + row.PersonId + `"
                                            data-firstname="` + row.FirstName + `"
                                            data-lastname="` + row.LastName + `"
                                            data-age="` + row.Age + `"
                                        >Edit</button>
                                        <button 
                                            class="btn-delete"
                                            data-personid="` + row.PersonId + `"
                                        >Delete</button>
                                    </td>
                                </tr>`;
                    });

                    $('#table-person tbody').html(html);
                    tablePerson = $('#table-person').DataTable();
                }
            });
        }

        // Add event on all .btn-edit
        $('#table-person').on('click', '.btn-edit', function() {

            $('#personid').val( $(this).attr('data-personid') );
            $('#firstname').val( $(this).attr('data-firstname') );
            $('#lastname').val( $(this).attr('data-lastname') );
            $('#age').val( $(this).attr('data-age') );
            
        });

        // Add event on #btn-update
        $('#btn-update').click(function() {
            
            // Connect to database thru AJAX
            $.ajax({
                url: '<?php echo base_url('queries/updatePerson.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-person').serializeArray(), // <- transform form data to JSON
                success: function(result) {
                    // If query is success execute here
                    getAllPersons();
                    ClearForm();
                }
            });
        });

        // Add event on all .btn-delete
        $('#table-person').on('click', '.btn-delete', function() {

            var personId = $(this).attr('data-personid');
            var data = [{ name : 'personid', value : personId }];

            // Connect to database thru AJAX
            $.ajax({
                url: '<?php echo base_url('queries/deletePerson.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(result) {
                    // If query is success execute here
                    getAllPersons();
                    ClearForm();
                }
            });

        });

        $('#btn-clear').click(ClearForm);

        function ClearForm() {
            $('#personid').val( '' );
            $('#firstname').val( '' );
            $('#lastname').val( '' );
            $('#age').val( '' );
        }

    });
</script>

<?php require_once '../common/footer-admin.php'; ?>