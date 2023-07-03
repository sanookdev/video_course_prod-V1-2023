<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('./');?>" class="brand-link">
        <img src="<?= base_url('img/logo/medlogopng.png') ?>" alt="<?= $this->config->item('site_name'); ?>"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $this->session->options->sub_name ; ?>
        </span>
    </a>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= base_url('dist/img/user2-160x160.jpg')?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#"
                class="d-block text-light"><?= $this->session->userdata['fname']. " " . $this->session->userdata['lname'];?></a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= site_url('dashboard');?>" class="nav-link nav-dashboard active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">SEXology Course</li>

                <li class="nav-item has-treeview course_menu">
                    <a href="#" id="nav-headerVideos" class="nav-link">
                        <i class="nav-icon fas fa-video"></i>
                        <p>
                            <?= $this->config->item('course_menu');?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <? foreach ($title_menu as $key => $value) {?>
                        <li class="nav-item">
                            <a href="<?= site_url('videos/title/'.$value->id);?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?= $value->name ;?></p>
                            </a>
                        </li>
                        <?}?>
                        <!-- <li class="nav-item">
                            <a href="#" id="course_title" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Diploma-in-Sexual-Medicine</p>
                            </a>
                        </li> -->
                    </ul>
                </li>

                <li class="nav-header">MANAGE</li>
                <li class="nav-item has-treeview contents_header">
                    <a href="#" id="nav-header" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p> Videos Contents
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('videos/listtitle')?>" id="nav-listtitle" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Titles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('videos/listvideo')?>" id="nav-listvideo" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Videos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview users_header">
                    <a href="#" id="nav-header" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            <?= $this->config->item('users_menu');?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('users/report')?>" id="nav-report" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/add')?>" id="nav-add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/upload')?>" id="nav-upload" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload File</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="<?= site_url('setting');?>" id="nav-setting" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>



<script>
$(document).ready(function() {
    const url = <?= json_encode(current_url());?>;
    const lastSegment = url.substring(url.lastIndexOf('/') + 1);
    const colorMenu = <?= json_encode($this->session->options->menu_color)?>;

    checkActivePage = async () => {
        await clearActive();
        await addActivePage();
        await checkColorMenu();

    }

    clearActive = () => {
        if (lastSegment != '') {
            $('.has-treeview').removeClass('active');
        }
    }
    addActivePage = () => {
        if (lastSegment == "add") {
            $('#nav-add').addClass('active');
            $('.users_header').addClass('menu-open');
        } else if (lastSegment == "report") {
            $('#nav-report').addClass('active');
            $('.users_header').addClass('menu-open');
        } else if (lastSegment == "upload") {
            $('#nav-upload').addClass('active');
            $('.users_header').addClass('menu-open');
        } else if (lastSegment == "setting") {
            $('#nav-setting').addClass('setting_active');
        } else if (lastSegment == "listtitle") {
            $('#nav-listtitle').addClass('active');
            $('.contents_header').addClass('menu-open');
        } else if (lastSegment == "listvideo") {
            $('#nav-listvideo').addClass('active');
            $('.contents_header').addClass('menu-open');
        }
    }
    checkColorMenu = () => {
        $('.nav-header').css('color', `${colorMenu}`);
        $('.name_user').css('color', `${colorMenu}`);
        $('.nav-dashboard').css('background-color', `${colorMenu}`);
    }

    initialLoadSidebar = () => {
        checkActivePage();
    }

    initialLoadSidebar();
});
</script>