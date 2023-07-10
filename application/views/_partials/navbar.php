<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>

<body>
    <nav class="main-header navbar navbar-expand navbar-light navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= site_url('dashboard');?>" class="nav-link">Dashboard</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" onclick="changePassword('<?= $this->session->userdata('username');?>')"
                    role="button">
                    <i class="fas fa-edit"> Change password.</i>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="confirm_logout()" role="button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <?$this->load->view('modal_event/reset_pass');?>
    <script>
    $(document).ready(() => {
        confirm_logout = () => {
            alertify.confirm("You want to logout ?",
                function() {
                    window.location.href = "<?= site_url('member/logout');?>";
                },
                function() {
                    alertify.error('Cancel');
                }).set({
                title: '!! Are you sure ?'
            });
        }

        changePassword = (user_id) => {
            $('input[name="username"]').val(user_id);
            $('#reset_pass').modal('show');
        }

        $('#form_resetpass').on("submit", function(event) {
            event.preventDefault();
            let data = {};
            data['username'] = $('input[name=username]').val();
            data['password'] = $('input[name=password]').val();
            var baseUrl = "<?= base_url();?>";
            var submissionURL = baseUrl + 'Users/updatePassword';
            $.ajax({
                type: "POST",
                url: submissionURL,
                method: 'POST',
                dataType: 'json',
                data: {
                    data
                },
                success: function(res) {
                    if (res.status) {
                        alertify.success(res.message);
                        $('input[name=password]').val('');
                        $('#reset_pass').modal('hide');
                    } else {
                        alertify.error(res.message);
                    }
                },
            });
        });
    })
    </script>
</body>

</html>