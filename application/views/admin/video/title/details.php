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
    if(!isset($title[0])){
        show_404();
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
                                <li class="breadcrumb-item"><a href="#">Videos Contents</a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?= site_url('videos/title_manage')?>">Title</a>
                                </li>
                                <li class="breadcrumb-item active"><?= $title[0]->name ;?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?= $title[0]->name ;?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="card card-info card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title">
                                                        Videos
                                                    </h5>
                                                    <div class="card-tools">
                                                        <a href="<?= site_url('videos/addvideo')?>"
                                                            class="btn btn-tool text-success">
                                                            <i class="fas fa-plus"></i> Add Video
                                                        </a>
                                                        <a href="#" class="btn btn-tool">
                                                            <i class="fas fa-video"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <hr>
                                                        <a type="button" disabled
                                                            class="btn btn-sm btn-danger float-left delete_all_videos">Delete
                                                            Selected</a>

                                                        <table class="table table-bordered table-hover videos_tb">
                                                            <thead class="text-center bg-secondary">
                                                                <tr>
                                                                    <th width="3%">
                                                                        <input type="checkbox" id="masterVideos">
                                                                    </th>
                                                                    <th width="5%">V_ID</th>
                                                                    <th>NAME</th>
                                                                    <th width="10%">Filename</th>
                                                                    <th width="7%">Updated</th>
                                                                    <th width="5%">Status</th>
                                                                    <th width="10%">#</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="data">
                                                                <?$i = 1;
                                            foreach ($videos as $key => $value) {?>
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <input type="checkbox" class="sub_chkVideo"
                                                                            data-id="<?= $value->id;?>">
                                                                    </td>
                                                                    <td><?= $value->id;?></td>
                                                                    <td><?= $value->name."<br><p class = 'text-small text-info'>course : ".$value->title_name."</p>";?>
                                                                    </td>
                                                                    <td><?= $value->filename;?></td>
                                                                    <td><?= $value->last_updated;?></td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch">
                                                                            <input
                                                                                onclick="changePublic(this,'<?= $value->id?>','tb_videos','status')"
                                                                                type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="<?= 'status'.$i ;?>"
                                                                                name='machine_state'
                                                                                <?= ($value->status) ? "checked" : ""?>>
                                                                            <label class="custom-control-label"
                                                                                for="<?= 'status'.$i ;?>">
                                                                            </label>
                                                                        </div>
                                                                        <input type="hidden" name="form_submit"
                                                                            value="">
                                                                    </td>
                                                                    <td>

                                                                        <a class="btn btn-danger" targetDiv=""
                                                                            data-id="<?= $value->id?>"
                                                                            onclick="deleteVideo('<?= $value->id ;?>','<?= $value->title_id;?>','<?= $value->filename;?>')"><i
                                                                                class="fas fa-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?$i++;
                                        }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-info card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title">
                                                        Users Active
                                                    </h5>
                                                    <div class="card-tools">
                                                        <a href="#" class="btn btn-tool">
                                                            #
                                                        </a>
                                                        <a href="#" class="btn btn-tool">
                                                            <i class="fas fa-users"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <hr>
                                                        <a type="button" disabled
                                                            class="btn btn-sm btn-danger float-left delete_all_permission">Delete
                                                            Selected</a>
                                                        <table class="table table-bordered table-hover users_tb ">
                                                            <thead>
                                                                <tr class="text-center bg-secondary">
                                                                    <th width="3%"><input type="checkbox"
                                                                            id="masterPermission">
                                                                    </th>
                                                                    <th width="5%">User Id</th>
                                                                    <th width="10%">Created</th>
                                                                    <th>Fullname</th>
                                                                    <th>Username</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="data">
                                                                <?$i = 1;
                                            foreach ($users_active as $key => $value) {?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" class="sub_chkPermission"
                                                                            data-id="<?= $value->id;?>">
                                                                    </td>
                                                                    <td><?= $value->id;?></td>
                                                                    <td><?= $value->created;?></td>
                                                                    <td><?= $value->fname . " " . $value->lname ;?></td>
                                                                    <td><?= $value->username;?></td>
                                                                </tr>
                                                                <?$i++;
                                        }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-info card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title">
                                                        Users Inactive
                                                    </h5>
                                                    <div class="card-tools">
                                                        <a href="#" class="btn btn-tool ">
                                                            #
                                                        </a>
                                                        <a href="#" class="btn btn-tool">
                                                            <i class="fas fa-users"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <hr>
                                                        <a type="button" disabled
                                                            class="btn btn-sm btn-success float-left add_all_permission">Add
                                                            Selected</a>
                                                        <table class="table table-bordered table-hover inactive_tb">
                                                            <thead>
                                                                <tr class="text-center bg-secondary">
                                                                    <th width="3%"><input type="checkbox"
                                                                            id="masterUnPermission">
                                                                    </th>
                                                                    <th width="5%">User Id</th>
                                                                    <th width="10%">Created</th>
                                                                    <th>Fullname</th>
                                                                    <th>Username</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="data">
                                                                <?
                                            foreach ($users_inactive as $value) {
                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox"
                                                                            class="sub_chkUnPermission"
                                                                            data-id="<?= $value->id;?>">
                                                                    </td>
                                                                    <td><?= $value->id;?></td>
                                                                    <td><?= $value->created;?></td>
                                                                    <td><?= $value->fname . " " . $value->lname ;?></td>
                                                                    <td><?= $value->username;?></td>
                                                                </tr>
                                                                <?}?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
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


        <script type="text/javascript">
        $(document).ready(function() {
            const title_id = "<?= $title[0]->id ;?>";
            const title_details = <?= json_encode($title);?>;
            console.log(title_details);
            setupDataTable = () => {
                $('.videos_tb').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
                $('.users_tb').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
                $('.inactive_tb').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            initialLoad = async () => {
                await setupDataTable();
                await hideOverlay();
            }
            initialLoad();

            changePublic = (e, id, target, column) => {
                let where = "id=" + id;
                let table = target;
                let data = {};
                data['id'] = id;
                data['column'] = column;
                data['table'] = target;
                if ($(e).is(":checked")) {
                    data[column] = 1;
                } else {
                    data[column] = 0;
                }
                let baseUrl = "<?= base_url();?>";
                let submissionURL = baseUrl + 'Admin/updateStatus';
                $.ajax({
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',
                    url: submissionURL,
                    data: {
                        data: data
                    },
                    success: function(res) {
                        if (res.status) {
                            alertify.success(res.message);
                        } else {
                            alertify.error(res.message);
                        }
                    }
                });
            }


            deleteUserPermission = (user_id) => {
                let data = {};
                alertify.confirm("Are you sure for delete permission for user id : '" + user_id + "' ?",
                    function() {
                        data['id'] = title_id;
                        var baseUrl = "<?= base_url();?>";
                        var submissionURL = baseUrl + 'Admin/deleteTitle';
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
                                    alertify
                                        .alert(res.message,
                                            function() {
                                                location.reload();
                                            });
                                } else {
                                    console.log(res);
                                    // alertify.error(res.message);
                                }
                            },
                        });
                    },
                    function() {
                        alertify.error('Cancel');
                    });
            }
            deleteVideo = (video_id, title_id, filename) => {
                let data = {};
                alertify.confirm("Are you sure for delete video id : '" + video_id + "' ?",
                    function() {
                        data['id'] = video_id;
                        data['title_id'] = title_id;
                        data['filename'] = filename;
                        let baseUrl = "<?= base_url();?>";
                        let submissionURL = baseUrl + 'Admin/deleteVideo';
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
                                    alertify
                                        .alert(res.message,
                                            function() {
                                                location.reload();
                                            });
                                } else {
                                    alertify.error(res.message);
                                }
                            },
                        });
                    },
                    function() {
                        alertify.error('Cancel');
                    });
            }
            $('#masterVideos').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chkVideo").prop('checked', true);
                } else {
                    $(".sub_chkVideo").prop('checked', false);
                }
            });

            $('#masterPermission').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chkPermission").prop('checked', true);
                } else {
                    $(".sub_chkPermission").prop('checked', false);
                }
            });
            $('#masterUnPermission').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chkUnPermission").prop('checked', true);
                } else {
                    $(".sub_chkUnPermission").prop('checked', false);
                }
            });
            $('.delete_all_videos').on('click', function(e) {
                var allVals = [];
                $(".sub_chkVideo:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                //alert(allVals.length); return false;  
                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    //$("#loading").show(); 
                    WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";

                    alertify.confirm(WRN_PROFILE_DELETE,
                        function() {
                            var baseUrl = "<?= base_url();?>";
                            var submissionURL = baseUrl + 'Admin/deleteMultiple';
                            let dataSelected = [];
                            let table = 'tb_videos';
                            $.each(allVals, function(index, value) {
                                dataSelected.push(value);
                            });
                            $.ajax({
                                method: 'POST',
                                type: 'POST',
                                dataType: 'json',
                                url: submissionURL,
                                data: {
                                    data: dataSelected,
                                    table: table
                                },
                                success: function(res) {
                                    if (res.status) {
                                        alertify
                                            .alert(res.message,
                                                function() {
                                                    location.reload();
                                                });
                                    } else {
                                        alertify.error(res.message);
                                    }
                                },
                            });
                        },
                        function() {
                            alertify.error('Cancel');
                        });
                }
            });
            $('.delete_all_permission').on('click', function(e) {
                var allVals = [];
                $(".sub_chkPermission:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });
                //alert(allVals.length); return false;  
                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    //$("#loading").show(); 
                    WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";

                    alertify.confirm(WRN_PROFILE_DELETE,
                        function() {
                            var baseUrl = "<?= base_url();?>";
                            var submissionURL = baseUrl + 'Admin/deleteMultiple';
                            let dataSelected = [];
                            let table = 'tb_permission_title';
                            $.each(allVals, function(index, value) {
                                dataSelected.push(value);
                            });
                            $.ajax({
                                method: 'POST',
                                type: 'POST',
                                dataType: 'json',
                                url: submissionURL,
                                data: {
                                    data: dataSelected,
                                    table: table
                                },
                                success: function(res) {
                                    if (res.status) {
                                        alertify
                                            .alert(res.message,
                                                function() {
                                                    location.reload();
                                                });
                                    } else {
                                        alertify.error(res.message);
                                    }
                                },
                            });
                        },
                        function() {
                            alertify.error('Cancel');
                        });
                }
            });

            $('.add_all_permission').on('click', function(e) {
                var allVals = [];
                $(".sub_chkUnPermission:checked").each(function() {
                    let obj = {
                        'title_id': title_id,
                        'user_id': $(this).attr('data-id'),
                        'created_by': 'ADMIN'
                    };
                    allVals.push(obj);
                });
                //alert(allVals.length); return false;  
                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {
                    //$("#loading").show(); 
                    WRN_PROFILE_DELETE = "Are you sure you want to add all this row?";

                    alertify.confirm(WRN_PROFILE_DELETE,
                        function() {
                            var baseUrl = "<?= base_url();?>";
                            var submissionURL = baseUrl + 'Admin/addMultiple';
                            let table = 'tb_permission_title';
                            $.ajax({
                                method: 'POST',
                                type: 'POST',
                                dataType: 'json',
                                url: submissionURL,
                                data: {
                                    data: allVals,
                                    table: table
                                },
                                success: function(res) {
                                    if (res.status) {
                                        alertify
                                            .alert(res.message,
                                                function() {
                                                    location.reload();
                                                });
                                    } else {
                                        alertify.error(res.message);
                                    }
                                },
                            });
                        },
                        function() {
                            alertify.error('Cancel');
                        });
                }
                console.log(allVals);
            });
        })
        </script>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
</body>

</html>