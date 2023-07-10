<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<body class="hold-transition sidebar-mini layout-fixed">
    <?
     if($this->session->flashdata('status') == '1'){?>
    <script>
    alertify
        .alert(<?= json_encode($this->session->flashdata('err_message'))?>).set({
            title: 'Notification !'
        });
    </script>
    <?}?>

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
                                <li class="breadcrumb-item"><a href="#">Video Contents </a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?= site_url('videos/list_manage');?>">Videos </a>
                                </li>
                                <li class="breadcrumb-item active">Add</li>
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
                                    <h3>Add Video</h3>
                                </div>
                                <div class="card-body">
                                    <form class="uploadForm" action="<?= base_url('Admin/upl_video') ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="title_id">Course Name</label>
                                                <select name="title_id" id="title_id"
                                                    class="form-control form-control-sm" required>
                                                    <option value="">Choose...</option>
                                                    <? foreach ($titles as $key => $value) { ?>
                                                    <option value="<?= $value->id ;?>"><?= $value->name ;?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="updated">Update Date</label>
                                                <input type="date" name="updated" id="updated"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="form-row mt-3">
                                            <div class="col-md-6">
                                                <label for="name">Video Name</label>
                                                <input type="text" class="form-control form-control-sm" id="name"
                                                    name="name" placeholder="Enter your video name .." required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Video File</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="video" name="video"
                                                        onchange="changeNameFileinput($(this))">
                                                    <label class="custom-file-label" for="video">Choose
                                                        Video ( MP4 only )...</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row mt-2">
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
                                            <hr>

                                        </div>
                                        <div class="form-row mt-2">
                                            <div class="col-md-12 float-right">
                                                <button type="submit"
                                                    class="btn btn-sm btn-block btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </form>

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

    <script>
    $(document).ready(async () => {
        hideOverlay();
        changeNameFileinput = (e) => {
            let id = e[0].id;
            var filename = e.val().replace(/C:\\fakepath\\/i, '')
            $('label[for=' + id + ']').text(filename);
        }
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
                            $(".uploadForm")[0].reset();
                            $('button[type="submit"]').attr('disabled', false);
                            $('label[for=video]').text('ChooseVideo ( MP4 only )...');
                            alertify.alert(response.message,
                                function() {
                                    window.history.back();
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