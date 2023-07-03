<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" />

<body class="hold-transition sidebar-mini layout-fixed">
    <?

    if($this->session->flashdata('status') == '1'){
        echo "<script>alertify.success('".$this->session->flashdata('err_message')."')</script>";
    }
    ?>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="max-height:1200px!important;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Settings</a>
                                </li>
                                <li class="breadcrumb-item active">Setting website</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Setting</h3>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('setting/update');?>" method="post">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="website_name">Website Name</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="website_name" placeholder="Your web site name."
                                                    value="<?= $options->website_name ;?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sub_name">Sub Name</label>
                                                <input type="text" class="form-control form-control-sm" name="sub_name"
                                                    placeholder="Your website sub name."
                                                    value="<?= $options->sub_name ;?>" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="menu_color">Menu Color
                                                    <span class="badge preview_color"
                                                        style="background-color:<?= $options->menu_color?>"><?= $options->menu_color;?>
                                                    </span>
                                                </label>
                                                <input name="menu_color" id="menu_color"
                                                    class="form-control form-control-sm"
                                                    value="<?= $options->menu_color;?>" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button type="submit"
                                                    class="btn btn-sm btn-success float-right">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <form class="uploadForm" action="<?= base_url('setting/upl_img') ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <div><a href="#" class="pop_banner">
                                                        <img id="imageresource1"
                                                            src="<?= base_url('uploads/banner/') . $options->banner_img1 ; ?>"
                                                            style="width: 300px; height: 264px; border: 3px solid #17a2b8;
                                                        padding: 15px;">
                                                    </a>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="banner_img1">Banner Image 1</label>
                                                    <input type="file" class="form-control-file" id="banner_img1"
                                                        name="banner_img1">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form class="uploadForm" action="<?= base_url('setting/upl_img') ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <div class=""><a href="#" class="pop_banner">
                                                        <img id="imageresource2"
                                                            src="<?= base_url('uploads/banner/') . $options->banner_img2 ; ?>"
                                                            style="width: 300px; height: 264px; border: 3px solid #17a2b8;
                                                        padding: 15px;">
                                                    </a>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="banner_img2">Banner Image 2</label>
                                                    <input type="file" class="form-control-file" id="banner_img2"
                                                        name="banner_img2">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form class="uploadForm" action="<?= base_url('setting/upl_img') ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <div class=""><a href="#" class="pop_banner">
                                                        <img id="background_img_login"
                                                            src="<?= base_url('uploads/banner/') . $options->background_img_login ; ?>"
                                                            style="width: 300px; height: 264px; border: 3px solid #17a2b8;
                                                        padding: 15px;">
                                                    </a>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="background_img_login">Backgound Login</label>
                                                    <input type="file" class="form-control-file"
                                                        id="background_img_login" name="background_img_login">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="progress">
                                                <div id="file-progress-bar" class="progress-bar"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <span id="chk-error"></span>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="uploaded_file"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    const siteUrl = <?= json_encode(site_url());?>;
    $(document).ready(async function() {
        await hideOverlay();
        $('#menu_color').colorpicker();
        $('#menu_color').on('change', () => {
            let colorCode = $('#menu_color').val();
            $(".preview_color").css("background-color", `${colorCode}`);
        })

        $(".pop_banner").on("click", await
            function() {
                let img = $(this).find('img');
                let src = img.attr('src');
                $('#imagepreview').attr('src', src);
                $('#imagemodal').modal(
                    'show'
                ); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
            });
        $('.uploadForm').on('submit', await
            function(e) {
                $("#chk-error").html('');
                $('.progress').show();

                e.preventDefault();

                // Disable the upload button
                $('button[type="submit"]').attr('disabled', true);

                // AJAX request to upload the image
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(element) {
                            if (element.lengthComputable) {
                                var percentComplete = ((element.loaded / element
                                    .total) * 100);
                                $("#file-progress-bar").width(percentComplete +
                                    '%');
                                $("#file-progress-bar").html(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function() {
                        $("#file-progress-bar").width('0%');
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status) {
                            $('button[type="submit"]').attr('disabled', false);
                            alertify
                                .alert(response.message, function() {
                                    window.location.reload();
                                });
                        } else {
                            $('button[type="submit"]').attr('disabled', false);
                            $("#file-progress-bar").width('0%');
                            alertify.error(response.message)
                        }
                    },
                    error: function() {
                        // Enable the upload button
                        $('button[type="submit"]').attr('disabled', false);

                        // Hide the progress bar
                        $('.progress').hide();

                        // Display an error message
                        alert('An error occurred during the upload.');
                    }
                });
            });
    });
    </script>
</body>

</html>