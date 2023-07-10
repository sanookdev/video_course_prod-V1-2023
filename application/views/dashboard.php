<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<body class="hold-transition sidebar-mini layout-fixed">
    <?
    if(isset($response)){
        if($response['status']){
            echo "<script>alertify.success('".$response['message']."')</script>";
        }else{
            echo "<script>alertify.warning('".$response['message']."')</script>";
        }
        unset($response);
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
                                <li class="breadcrumb-item"><a href="<?= site_url('dashboard');?>">Dashboard</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <? if($this->session->userdata['user_role'] == '1'){?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="small-box" style="background-color:rgb(245, 105, 84);">
                                <div class="inner">
                                    <h3><?= $countVideos;?></h3>
                                    <p>Videos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-video"></i>
                                </div>
                                <a href="<?= site_url('videos/list_manage');?>" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="small-box bg-gradient-info">
                                <div class="inner">
                                    <h3><?= $countUsers;?></h3>
                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <a href="<?= site_url('users/report');?>" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><?= $options->sub_name ;?></h5>
                                </div>

                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <img src="<?= base_url('uploads/banner/'.$options->banner_img1)?>"
                                                class=" card-img">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?= base_url('uploads/banner/'.$options->banner_img2)?>"
                                                class=" card-img">
                                        </div>
                                    </div>


                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header"
                                                    style="color:<?= $options->menu_color;?>"><?= $countUsers;?></h5>
                                                <span class="description-text">TOTAL PARTICIPANT</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header"
                                                    style="color:<?= $options->menu_color;?>"><?= $countVideos;?></h5>
                                                <span class="description-text">TOTAL VIDEOS</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
    <!-- ./wrapper -->

    <script>
    $(document).ready(() => {

        hideOverlay(); // from folder  :   _partials -> header

        initialLoad = async () => {
            await hideOverlay();
        }
    })
    </script>
</body>

</html>