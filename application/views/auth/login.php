<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span onclick="window.open('https://www.facebook.com/webmedtufanpage','_blank')"><i
                                class="fab fa-facebook-square"></i></span>
                        <span onclick="window.open('https://www.tacs.or.th/','_blank')"><i
                                class="fas fa-globe"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <?
                            if($this->session->flashdata('err_message')){
                                echo "<p class = 'alert alert-warning'>".($this->session->flashdata('err_message')). "</p>";
                            }
                        ?>
                    <form action="<?= site_url('member/check');?>" method="post">
                        <div class="form-group error-message">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="email" placeholder="Username" minlength="4"
                                required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                minlength="4" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        <?= $options->sub_name ;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const background_img = <?= json_encode($options->background_img_login);?>;
        const uploads_path = <?= json_encode(base_url('uploads/banner/'));?>;
        if (background_img.length > 0) {
            $('body').css('background-image', `url(${uploads_path}${background_img})`);
        }
    })
    </script>
</body>

</html>