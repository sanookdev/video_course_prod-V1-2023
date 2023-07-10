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
                                <li class="breadcrumb-item"><a href="#">Videos</a>
                                </li>
                                <li class="breadcrumb-item active"><?= $title[0]->name;?></li>
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
                                    <h3 class="card-title text-bold">
                                        <?= $title[0]->name;?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?if(count($contents) == 0){echo "Video is empty.";}?>
                                    <div class="form-row">
                                        <?foreach ($contents as $key => $value) {?>
                                        <div class="col-md-4">
                                            <div class="card card-info card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title">
                                                        <?= $value->name."<br><p class = 'small text-info'>updated : ".$value->last_updated."</p>" ;?>
                                                    </h5>
                                                    <div class="card-tools">
                                                        <a href="#" class="btn btn-tool"><?= 'V_ID #'.$value->id ;?></a>
                                                        <a href="#" class="btn btn-tool">
                                                            <i class="fas fa-video"></i>
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <button onclick="showVideo('<?= $value->id?>')"
                                                            class="btn btn-sm btn-info btn-block">
                                                            <i class="fas fa-video"></i> Click to show video. </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?}?>
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
            const title = <?= json_encode($title[0]);?>;


            initialLoad = async () => {
                await hideOverlay();
            }
            initialLoad();


            showVideo = (v_id) => {
                if (v_id != '' && typeof(v_id) !== undefined) {
                    window.location.href = "<?= site_url('Videos/play/');?>" + v_id;
                }
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

            $(document).on('click', '.edit_data', () => {
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