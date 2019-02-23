<?php require_once '../common/header.php'; ?>

<style>
    html,
    body {
        height: 100%;
    }

    #form-login label {
        display: inline-block;
        width: 100px;
    }

    #form-login input {
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
            
            <form id="form-login">
                <h1 class="text-center mb-3 text-center">LOGIN</h1>
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" placeholder="username" require>
                <br>
                <label for="password" class="mt-2">Password: </label>
                <input type="password" name="password" id="password" placeholder="password" require>
                <br>
                <div class="row mt-2 text-center">
                    <div class="col-6">
                        <a href="<?php echo base_url('view/admin/forgot.php'); ?>" class="btn btn-secondary">Forgot Password?</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-login').submit(function(e) {
            e.preventDefault();

            login();
        });

        function login() {
            $.ajax({
                url: '<?php echo base_url('queries/loginAdmin.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-login').serializeArray(),
                success: function(result) {
                    if (result.success === true) {
                        window.location.href = '<?php echo base_url('view/report/index.php'); ?>';
                    } else {
                        alert("Invalid username or password");
                    }
                }
            });
        }
    });
</script>

<?php require_once '../common/footer.php'; ?>