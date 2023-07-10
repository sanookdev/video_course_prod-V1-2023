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
                                <li class="breadcrumb-item"><a href="<?= site_url('videos/title');?>">Title </a>
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
                                    <h3>Add Title</h3>
                                </div>
                                <div class="card-body">
                                    <form id="formAddTitle" action="<?= site_url('Admin/createTitle');?>" method="post">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label for="name">Title Name</label>
                                                <input type="text" class="form-control form-control-sm" id="name"
                                                    name="name" required>
                                            </div>
                                        </div>
                                        <div class="form-row mt-2">
                                            <div class="col-md-12 text-right">
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
</body>

</html>