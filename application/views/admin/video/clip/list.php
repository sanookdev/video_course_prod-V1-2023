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
                                    <h3 class="card-title">Title</h3>
                                </div>
                                <div class="card-body">
                                    <?
                                        foreach ($contents as $key => $value) {?>
                                    <div class="card card-info card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                <?= $value->name."<br><p class = 'small text-info'>updated : ".$value->created."</p>" ;?>
                                            </h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link"><?= '#'.$value->id ;?></a>
                                                <a href="<?= base_url('uploads/video/'.$value->title_id.'/'.$value->path);?>"
                                                    class="btn btn-tool">
                                                    <i class="fas fa-video"></i>
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <button onclick="showVideo('<?= $value->title_id?>','<?= $value->id?>')"
                                                    class="btn btn-sm btn-info btn-block">
                                                    <i class="fas fa-video"></i> Show Video </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
        </div>


        <script type="text/javascript">
        $(document).ready(function() {
            setupDataTable = () => {
                $('.title_tb').DataTable({
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


            showVideo = (title_id, v_id) => {
                console.log(title_id, v_id);
            }

            changePublic = (e, id, target, column) => {
                let where = "id=" + id;
                let table = target;
                let data = {};
                data['id'] = id;
                data['column'] = column;
                if ($(e).is(":checked")) {
                    data[column] = 1;
                } else {
                    data[column] = 0;
                }
                let baseUrl = "<?= base_url();?>";
                let submissionURL = baseUrl + 'Videos/updateStatus';
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
            deleteTitle = (title_id) => {
                let data = {};
                alertify.confirm("Are you sure for delete title id : '" + title_id + "' ?",
                    function() {
                        data['id'] = title_id;
                        var baseUrl = "<?= base_url();?>";
                        var submissionURL = baseUrl + 'Videos/deleteTitle';
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
                            var submissionURL = baseUrl + 'Videos/deleteMultipleTitle';
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
                                    data: dataSelected
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