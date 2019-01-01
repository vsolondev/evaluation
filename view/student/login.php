<?php require_once '../common/header-admin.php'; ?>

<form id="form-login">
    <input type="text" name="username" id="username" placeholder="username">
    <input type="password" name="password" id="password" placeholder="password">
    <button type="submit">Login</button>
</form>

<script>
    $(document).ready(function() {
        $('#form-login').submit(function(e) {
            e.preventDefault();

            login();
        });

        function login() {
            $.ajax({
                url: '<?php echo base_url('queries/loginStudent.php'); ?>',
                type: 'post',
                dataType: 'json',
                data: $('#form-login').serializeArray(),
                success: function(result) {
                    if (result.success === true) {
                        window.location.href = '<?php echo base_url('view/student/home.php'); ?>';
                    }
                }
            });
        }
    });
</script>

<?php require_once '../common/footer-admin.php'; ?>