<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="<?= base_url($this->config->item('favicon')); ?>" type="image/x-icon">

    <title><?= $this->config->item('site_name') ?></title>

    <div id="overlay">
        <div id="loading">
            <img src="<?= base_url('img/loading.gif'); ?>" alt="Loading..." />
        </div>
    </div>


</head>

<body>
    <script>
    $(document).ready(() => {
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