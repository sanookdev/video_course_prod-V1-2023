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
                                <li class="breadcrumb-item"><a href="#">Videos Contents</a>
                                </li>
                                <li class="breadcrumb-item active">Title</li>
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
                                    <h3 class="card-title">Videos Management </h3>
                                    <div class="card-tools">
                                        <a href="<?= site_url('videos/addvideo')?>" class="text-success">
                                            <i class="fas fa-plus"></i> Add Video
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <a type="button" class="btn btn-danger float-left delete_all">Delete
                                        Selected</a>

                                    <table class="table table-bordered table-hover videos_tb">
                                        <thead class="text-center bg-secondary">
                                            <tr>
                                                <th width="3%"><input type="checkbox" id="master" disabled></th>
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
                                                    <input type="checkbox" disabled class="sub_chk"
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
                                                            type="checkbox" class="custom-control-input"
                                                            id="<?= 'status'.$i ;?>" name='machine_state'
                                                            <?= ($value->status) ? "checked" : ""?>>
                                                        <label class="custom-control-label" for="<?= 'status'.$i ;?>">
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="form_submit" value="">
                                                </td>
                                                <td>

                                                    <a class="btn btn-danger" targetDiv="" data-id="<?= $value->id?>"
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
                </div><!-- /.container-fluid -->
            </section>
        </div>


        <script type="text/javascript">
        $(document).ready(function() {

            const list_video = <?= json_encode($videos);?>;

            setupDataTable = () => {
                $('.videos_tb').DataTable({
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
                // await hideOverlay();
            }
            initialLoad();


            showVideo = (title_id, v_id) => {
                console.log(title_id, v_id);
            }

            changePublic = (e, id, target, column) => {
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

            $(document).on('click', '.edit_data', function() {
                var id = $(this).attr("id");
                $('input[name="username"]').val(id);
                $('#reset_pass').modal('show');
            });

            $('#form_resetpass').on("submit", function(event) {
                event.preventDefault();
                let where = "username=" + $('input[name=username]').val();
                let table = 'user';
                let data = {};
                data['username'] = $('input[name=username]').val();
                data['password'] = $('input[name=password]').val();
                var baseUrl = "<?= base_url();?>";
                var submissionURL = baseUrl + 'Users/updatePassword';
                $.ajax({
                    type: "POST",
                    url: submissionURL,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        data
                    },
                    success: function(data) {
                        $('#reset_pass').modal('hide');
                        $('input[name= password]').val('');
                        if (data.status) {
                            alertify.success(data.message);
                        } else {
                            alertify.error(data.message);
                        }
                    },
                });
            });
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
            $('#master').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            $('.delete_all').on('click', function(e) {
                var allVals = [];
                $(".sub_chk:checked").each(function() {
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
                                    table: 'tb_videos'
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
        })
        </script>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
</body>

</html>