<?php global $user?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" style="background:#343a40!important;" class="brand-link">
        <img src="./../assets/images/logo.png" alt="Logo" class="float-left bg-white p-1" ">
        <span class="brand-text font-weight-light">پنل <?= $user->role == 'admin' ? 'ادمین' : 'نویسنده' ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <a href="<?= $user->role ?>.php">
                    <div class="image">
                        <img src="../uploads/avatars/<?= $user->avatar ?>" class="img-circle elevation-2 bg-white" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= $user->role ?>.php" class="d-block"><?= $user->name ?></a>
                        <a href="<?= $user->role ?>.php?logout=<?= $user->id ?>" class="text-danger">خروج</a>
                    </div>
                </a>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= $user->role ?>.php" class="nav-link <?= !isset($_GET['page']) ? 'active' : '' ?>">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>
                    <?php if ($user->role == 'admin'): ?>
                    <li class="nav-item">
                        <a href="admin.php?page=user" class="nav-link <?= isset($page) && $page == 'user' ? 'active' : '' ?>">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                کاربران
                            </p>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="<?= $user->role ?>.php?page=post" class="nav-link <?= isset($page) && $page == 'post' ? 'active' : '' ?>">
                            <i class="nav-icon fa fa-light fa-table"></i>
                            <p>
                                پست ها
                            </p>
                        </a>
                    </li>
                    <?php if ($user->acc_lvl > 0 || $user->role == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= $user->role ?>.php?page=category" class="nav-link <?= isset($page) && $page == 'category' ? 'active' : '' ?>">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                دسته بندی ها
                            </p>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="<?= $user->role ?>.php?page=comment" class="nav-link <?= isset($page) && $page == 'comment' ? 'active' : '' ?>">
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