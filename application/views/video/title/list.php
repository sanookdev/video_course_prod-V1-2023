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
                                    <h3 class="card-title">All Title</h3>
                                    <div class="card-tools">
                                        <a href="<?= site_url('videos/addTitle')?>" class="text-success">
                                            <i class="fas fa-plus"></i> Add Title
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a type="button" class="btn btn-danger float-left delete_all">Delete
                                        Selected</a>

                                    <table class="table table-bordered table-hover title_tb">
                                        <thead>
                                            <tr class="text-center bg-secondary">
                                                <th width="3%"><input type="checkbox" id="master"></th>
                                                <th width="5%">ID</th>
                                                <th width="10%">Created</th>
                                                <th width="10%">Last updated</th>
                                                <th>Title Name</th>
                                                <th width="5%">status</th>
                                                <th width="5%" class="pull-right">#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data">
                                            <?$i = 1;
                                            foreach ($titles as $key => $value) {?>
                                            <tr class="text-center">
                                                <td>
                                                    <input type="checkbox" class="sub_chk" data-id="<?= $value->id;?>">
                                                </td>
                                                <td><?= $value->id;?></td>
                                                <td><?= $value->created;?></td>
                                                <td><?= $value->last_updated;?></td>
                                                <td><?= $value->name;?></td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            onclick="changePublic(this,'<?= $value->id?>','tb_title','status')"
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
                                                        onclick="deleteTitle('<?= $value->id ;?>')"><i
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