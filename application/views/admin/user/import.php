<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<body class="hold-transition sidebar-mini layout-fixed">
    <?
    if($this->session->flashdata('err_message')){
        echo "<script>alertify.success('".$this->session->flashdata('err_message')."')</script>";
    }
?>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="max-height:1200px!important;">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><?= $this->config->item('users_menu');?></a>
                                </li>
                                <li class="breadcrumb-item active">Upload File</li>
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
                        <div class="col-md-12 mt-5">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h4>นำเข้าข้อมูล</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="projects-tab" data-toggle="tab"
                                                href="#projects" role="tab" aria-controls="projects"
                                                aria-selected="true">นำเข้าไฟล์ข้อมูลผู้ใช้งาน</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="projects" role="tabpanel"
                                            aria-labelledby="projects-tab">
                                            <p class="pl-3 pt-2"><a href="<?= base_url('files/Example.xlsx')?>">Download
                                                    ไฟล์ตัวอย่าง</a></p>
                                            <form id="users-upload" autocomplete="off" class="mt-2">
                                                <div class="form-row mt-3">
                                                    <div class="col-md-12 input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="file"
                                                                name="file" onchange="changeNameFileinput($(this))">
                                                            <label class="custom-file-label" for="file">Choose
                                                                file ( Excel only )...</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button
                                                                class="btn btn-secondary btn-sm waves-effect waves-light">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="details_import mt-3">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row import projects-->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>


        <script type="text/javascript">
        $(document).ready(function() {
            $(document).ready(() => {
                hideOverlay();
            })
            changeNameFileinput = (e) => {
                let id = e[0].id;
                var filename = e.val().replace(/C:\\fakepath\\/i, '')
                $('label[for=' + id + ']').text(filename);
            }
            $("body").on("submit", "#users-upload", function(e) {
                e.preventDefault();
                let data = new FormData(this);
                console.log(data);
                // url: "<?= base_url('users/import') ?>",
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('uploadPHPExcel/import') ?>",
                    data: data,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#btnUpload").prop('disabled', true);
                        $(".user-loader").show();
                    },
                    success: function(result) {
                        console.log(result);
                        $("#btnUpload").prop('disabled', false);
                        if (result.status) {
                            let outputSuccess =
                                '<hr><h5 class = "text-success">รายการเพิ่มข้อมูลที่สำเร็จ</h5>';
                            if (result.success !== undefined) {
                                $.each(result.success.user, function(key, value) {
                                    outputSuccess += '<p>' + value + '</p>';
                                });
                            }
                            outputSuccess +=
                                '<h5 class = "text-danger">รายการเพิ่มข้อมูลที่ไม่สำเร็จ (มีอยู่แล้ว)</h5>';
                            if (result.fails !== undefined) {
                                $.each(result.fails.user, function(key, value) {
                                    outputSuccess += '<p>' + value + '</p>';
                                });
                            }

                            // console.log(outputSuccess);
                            $('.details_import').html(outputSuccess);

                            alertify.success("Import completed.");
                        } else {
                            alertify.error("Error");
                        }
                        $(".user-loader").hide();
                    }
                });
            });
        });
        </script>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
</body>

</html>