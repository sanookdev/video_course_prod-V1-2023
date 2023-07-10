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
                                <li class="breadcrumb-item"><a href="#"><?= $this->config->item('users_menu');?></a>
                                </li>
                                <li class="breadcrumb-item active">Users</li>
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
                                    <h3 class="card-title">User Management</h3>
                                    <div class="card-tools">
                                        <a href="<?= site_url('users/add')?>" class="text-success">
                                            <i class="fas fa-plus"></i> Add User
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a type="button" class="btn btn-danger float-left delete_all">Delete
                                        Selected</a>

                                    <table class="table table-bordered table-hover users_tb ">
                                        <thead>
                                            <tr class="text-center bg-secondary">
                                                <th width="3%"><input type="checkbox" id="master"></th>
                                                <th width="10%">Created</th>
                                                <th>Fullname</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Mobile</th>
                                                <th width="5%">Active</th>
                                                <th width="5%">Admin</th>
                                                <!-- <th width="10%">#</th> -->
                                                <th width="5%" class="pull-right">#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="data">
                                            <?$i = 1;
                                            foreach ($users as $key => $value) {?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="sub_chk"
                                                        data-id="<?= $value->username;?>">
                                                </td>
                                                <td><?= $value->created;?></td>
                                                <td><?= $value->fname . " " . $value->lname ;?></td>
                                                <td><?= $value->username;?></td>
                                                <td>

                                                    <button type="button"
                                                        class="btn btn-sm btn-block btn-info edit_data"
                                                        onclick="resetPasswordUser('<?= $value->username?>','<?= $value->phone?>')">
                                                        <i class="fas fa-undo"></i>
                                                        Reset password
                                                    </button>
                                                    <p class="small text-center" style="opacity:0.8">Default password is
                                                        mobile no.</p>
                                                </td>
                                                <td><?= $value->phone;?></td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            onclick="changePublic(this,'<?= $value->username?>','user','status_active')"
                                                            type="checkbox" class="custom-control-input"
                                                            id="<?= 'status_active'.$i ;?>" name='machine_state'
                                                            <?= ($value->status_active) ? "checked" : ""?>>
                                                        <label class="custom-control-label"
                                                            for="<?= 'status_active'.$i ;?>">
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="form_submit" value="">
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input
                                                            onclick="changePublic(this,'<?= $value->username?>','user','user_role')"
                                                            type="checkbox" class="custom-control-input"
                                                            id="<?= 'user_role'.$i ;?>" name='machine_state2'
                                                            <?= ($value->user_role == '1') ? "checked" : ""?>>
                                                        <label class="custom-control-label"
                                                            for="<?= 'user_role'.$i ;?>">
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="form_submit" value="">
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger" targetDiv=""
                                                        data-id="<?= $value->username?>"
                                                        onclick="deleteUser('<?= $value->username ;?>')"><i
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
                $('.users_tb').DataTable({
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
                data['username'] = id;
                data['column'] = column;
                if ($(e).is(":checked")) {
                    data[column] = 1;
                } else {
                    (column != 'user_role') ? data[column] = 0: data[column] = 2;
                }
                let baseUrl = "<?= base_url();?>";
                let submissionURL = baseUrl + 'Users/updateStatus';
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

            resetPasswordUser = (username, phone) => {
                alertify.confirm("Are you sure for reset password account '" + username + "' ?",
                    function() {
                        let data = {};
                        data['username'] = username;
                        data['phone'] = phone;
                        var baseUrl = "<?= base_url();?>";
                        var submissionURL = baseUrl + 'Users/resetPasswordUser';
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


            deleteUser = (username) => {
                let data = {};
                alertify.confirm("Are you sure for delete account '" + username + "' ?",
                    function() {
                        data['username'] = username;
                        var baseUrl = "<?= base_url();?>";
                        var submissionURL = baseUrl + 'Users/deleteUser';
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
                            var submissionURL = baseUrl + 'Users/deleteMultipleUser';
                            let dataSelected = [];
                            $.each(allVals, function(index, value) {
                                dataSelected.push(value);
                                //   $('table tr').filter("[data-row-id='" + value + "']").remove();
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