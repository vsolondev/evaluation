<?php require_once '../common/header.php'; ?>

<style>
    html,
    body {
        height: 100%;
    }

    #form-forgot label {
        display: inline-block;
        width: 100px;
    }

    #form-forgot input {
        display: inline-block;
        padding: 4px 5px;
        border: 1px solid;
        width: 222px;
    }

    .btn {
        width: 150px;
    }
</style>

<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 d-flex justify-content-center align-items-center h-100">
            
            <form id="form-forgot">
                <h1 class="text-center mb-3 text-center">Forgot Password</h1>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" placeholder="username" require>
                <br>
                <label for="pin" class="mt-2">Pin: </label>
                <input type="text" name="pin" id="pin" placeholder="Pin" require>
                <br>
                <div class="row mt-2 text-center">
                    <div class="col-6">
                        <a href="<?php echo base_url('view/teacher/login.php'); ?>" class="btn btn-secondary">Back to Login</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary">Retrieve</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-forgot').submit(function(e) {
            e.preventDefault();

            getPassword();
        });

        function getPassword() {
            $.ajax({
                url: '<?php echo base_url('queries/getPassword.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-forgot').serializeArray(),
                success: function(result) {
                    if (result.success === true) {
                        alert("Your password is : " + result.password);
                    } else {
                        alert("Username or Pin does not match");
                    }
                }
            });
        }
    });
</script>

<?php require_once '../common/footer.php'; ?>