<?php require_once '../common/header-admin.php'; ?>

<style>
    #form-account label {
        display: inline-block;
        width: 120px;
    }

    #form-account input,
    #form-account select {
        display: inline-block;
        padding: 4px 8px;
        width: 200px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form id="form-account">
                <div class="row mt-4 mb-5">
                    <div class="col-12">
                        <label for="firstname">Firstname: </label>
                        <input type="text" id="firstname" name="firstname" placeholder="firstname">
                        <br>
                        <label for="lastname">Lastname: </label>
                        <input type="text" id="lastname" name="lastname" placeholder="lastname">
                        <br>
                        <label for="middlename">Middlename: </label>
                        <input type="text" id="middlename" name="middlename" placeholder="middlename">
                        <br>
                        <label for="pin">Pin: </label>
                        <input type="text" id="pin" name="pin" placeholder="Pin">
                        <br>
                        <button type="button" id="btn-save" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btn-save').click(function() {
            $.ajax({
                url: '<?php echo base_url('queries/updateAdminAccount.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-account').serializeArray()
            });
        });

        getAccount();

        function getAccount() {
            $.ajax({
                url: '<?php echo base_url('queries/getAdminAccount.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    var myAccountData = result.data;
                    
                    $("#firstname").val(myAccountData.FirstName);
                    $("#lastname").val(myAccountData.LastName);
                    $("#middlename").val(myAccountData.MiddleName);
                    $("#pin").val(myAccountData.Pin);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>