<?php global $user?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" style="background:#343a40!important;" class="brand-link">
        <img src="./../assets/images/logo.png" alt="Logo" class="float-left bg-white p-1" ">
        <span class="brand-text font-weight-light">پنل ادمین</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <a href="admin.php">
                    <div class="image">
                        <img src="../uploads/avatars/<?= $user->avatar ?>" class="img-circle elevation-2 bg-white" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="admin.php" class="d-block"><?= $user->name ?></a>
                    </div>
                </a>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link active">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                کاربران
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fa fa-light fa-table"></i>
                            <p>
                                پست ها
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                دسته بندی ها
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fa fa-comment"></i>
                            <p>
                                کامنت ها
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>