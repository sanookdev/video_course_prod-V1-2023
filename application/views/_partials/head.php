<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="<?= base_url($this->config->item('favicon')); ?>" type="image/x-icon">

    <title><?= $options->website_name ?></title>

    <div id="overlay">
        <div id="loading">
            <img src="<?= base_url('img/loading.gif'); ?>" alt="Loading..." />
        </div>
    </div>


</head>

<body>
    <script>
    $(document).ready(() => {
        const options = <?= json_encode($options);?>;
        const users_session = <?= json_encode($this->session->userdata);?>

        console.log(options);
        console.log(users_session);
        showOverlay = () => {
            $('#overlay').show();
        }
        hideOverlay = () => {
            setTimeout(() => {
                $('#overlay').hide();
            }, 500);
        }
    })
    </script>
</body>

</html>