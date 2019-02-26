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

    #image {
        width: 250px;
        height: auto;
        display: block;
        margin-top: 30px;
        margin-bottom: 30px;
        margin-left: 30px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <img src="#" id="image">
            <form action="form-image">
                <label for="imagefile">Image File: </label>
                <input type="file" name="imagefile" id="imagefile" accept=".jpg,.jpeg,.gif,.png">
                <div>Allowed File Type : .jpeg, .jpg, .png, .gif</div>
            </form>

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
                        <br>
                        <h6>If you want to change your password.</h6>
                        <h6>Just Change the characters below.</h6>
                        <label for="password">Password: </label>
                        <input type="text" id="password" name="password" placeholder="Password">
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

            var formData = new FormData();
            formData.append('file', $('#imagefile')[0].files[0]);

            $.ajax({
                url: '<?php echo base_url('queries/uploadImage.php'); ?>',
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function(result) {
                    getImage();
                }
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
                    $("#password").val(myAccountData.Password);
                }
            });
        }

        getImage();

        function getImage() {
            $.ajax({
                url: '<?php echo base_url('queries/getImageByAccountId.php'); ?>',
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    $('#image').attr('src', result.image);
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>