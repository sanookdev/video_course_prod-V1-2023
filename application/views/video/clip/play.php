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
                                <li class="breadcrumb-item">Video Contents</li>
                                <li class="breadcrumb-item">Videos</li>
                                <li class="breadcrumb-item"><a
                                        href="<?= site_url('videos/subject/').'19';?>"><?= $video_details[0]->title_name;?>
                                    </a></li>
                                <li class="breadcrumb-item active"><?= $video_details[0]->name ;?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card ">
                                <video id="my-video" class="video-js vjs-theme-city card-img-top" controls
                                    preload="auto" height="600px" p data-setup="{}">
                                    <source src="<?= $video_url;?>" type="video/mp4" />
                                </video>
                                <div class="card-body text-center bg-dark text-white">
                                    <h3 style="color:<?= $options->menu_color ;?>">
                                        <?= $video_details[0]->name;?>
                                    </h3>
                                    <p class="card-text"><?= 'Updated : '.$video_details[0]->last_updated; ?></p>
                                    <a href="<?= site_url('videos/subject/').$video_details[0]->title_id;?>"
                                        class="btn btn-info btn-sm btn-block">Go
                                        Back</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-bold">
                                        <?= $title[0]->name;?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover videos_tb ">
                                        <thead>
                                            <tr>
                                                <th width="3%">V_ID</th>
                                                <th>V_NAME</th>
                                                <th>UPDATED</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?foreach ($contents as $key => $value) {?>
                                            <tr>
                                                <td><?= $value->id ;?></td>
                                                <td><?= $value->name ;?></td>
                                                <td><?= $value->last_updated;?></td>
                                                <td><button onclick="showVideo('<?= $value->id?>')"
                                                        class="btn btn-sm btn-info btn-block">
                                                        <i class="fas fa-video"></i> Watch. </button></td>
                                            </tr>
                                            <?}?>
                                        </tbody>
                                    </table>
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

    <script>
    $(document).ready(async () => {
        // hideOverlay();
        setupDataTable = () => {
            $('.videos_tb').DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 8
            });
        }
        // first image poster video  media will use capture img from current time video 
        loadImagePoster = () => {
            let video = Popcorn("#my-video");
            video.listen("canplayall", function() {
                this.currentTime(10).capture();
            });
        }


        showVideo = (v_id) => {
            if (v_id != '' && typeof(v_id) !== undefined) {
                window.location.href = "<?= site_url('Videos/play/');?>" + v_id;
            }
        }

        await setupDataTable();
        await loadImagePoster();

    });
    </script>
</body>

</html>