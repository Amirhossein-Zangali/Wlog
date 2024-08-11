<?php

use Wlog\Model\Comment;
use Wlog\Model\Post;

require_once '../init.php';
if (isset($_SESSION['user_id']))
    $user = \Wlog\Model\User::find($_SESSION['user_id']);
else
    header("location:./index.php");

if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    header('location:./../index.php');
}

if ($user->role != 'admin')
    header("location:./index.php");
if (isset($_GET['page'])) {
    if ($_GET['page'] == 'user' || $_GET['page'] == 'post' || $_GET['page'] == 'category' || $_GET['page'] == 'comment')
        $page = $_GET['page'];
    else
        header("location:./admin.php");
}
function get_url($key)
{
    $url = 'admin.php?';
    foreach ($_GET as $index => $val) {
        if ($index == $key) {
            continue;
        }
        $url .= "$index=$val&";
    }
    return $url;
}

if (isset($_POST['edit']) && $_POST['table'] == 'user' && $_POST['role'] == 'admin') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $result = \Wlog\Model\User::find($_POST['id']);
    $result->name = $name;
    $result->username = $username;
    $result->email = $email;
    if (!empty($password))
        $result->password = password_hash($password, PASSWORD_DEFAULT);
    $result->update();
    header('location:./admin.php');
} else if (isset($_POST['edit'])) {
    if ($_POST['table'] == 'user') {
        $name = trim($_POST['name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $result = \Wlog\Model\User::find($_POST['id']);
        $result->name = $name;
        $result->username = $username;
        $result->email = $email;
        if (isset($_POST['role']))
            $result->role = $_POST['role'];
        if (isset($_POST['acc_lvl']))
            $result->acc_lvl = $_POST['acc_lvl'];

    }
    if ($_POST['table'] == 'post') {
        $user_id = trim($_POST['user_id']);
        $title = trim($_POST['title']);
        $des = trim($_POST['des']);
        $category_id = trim($_POST['category']);
        $result = \Wlog\Model\Post::find($_POST['id']);
        if ($_FILES['thumbnail']['error'] > 0)
            $thumbnail = $result->thumbnail;
        else {
            $thumbnail = $_FILES['thumbnail'];
            $thumbnail_type = explode('.', $thumbnail['name'])[1];
            $thumbnail_name = explode('.', $thumbnail['name'])[0] . '_' . time() . '.' . $thumbnail_type;
            if (move_uploaded_file($thumbnail['tmp_name'], '../uploads/thumbnails/' . $thumbnail_name))
                $thumbnail = $thumbnail_name;
            else $thumbnail = $result->thumbnail;
        }
        $result->user_id = $user_id;
        $result->title = $title;
        $result->thumbnail = $thumbnail;
        $result->des = $des;
        $result->category_id = $category_id;
    }
    if ($_POST['table'] == 'category') {
        $name = trim($_POST['name']);
        $sub_cat_id = trim($_POST['subcat']);
        $result = \Wlog\Model\Category::find($_POST['id']);
        $result->name = $name;
        $result->subcat_id = $sub_cat_id;
    }
    $result->update();
    header('location: ./admin.php?page=' . $_POST['table']);
}

if (isset($_POST['reply']) && isset($_POST['table']) && $_POST['table'] == 'comment') {
    $post_id = (Comment::find($_POST['reply']))->post_id;
    $user_id = trim($_POST['user_id']);
    $content = trim($_POST['content']);
    $reply = trim($_POST['reply']);

    $result = new \Wlog\Model\Comment();
    $result->post_id = $post_id;
    $result->user_id = $user_id;
    $result->content = $content;
    $result->reply = $reply;
    $result->status = 1;
    $result->save();
    header('location: ./admin.php?page=' . $_POST['table']);
}

if (isset($_GET['approve']) || isset($_GET['reject'])) {
    if ($_GET['approve']) {
        $comment_id = $_GET['approve'];
        $status = 1;
    }
    else if ($_GET['reject']){
        $comment_id = $_GET['reject'];
        $status = -1;
    }
    $comment = Comment::find($comment_id);
    if ($comment)
    {
        $comment->status = $status;
        $comment->update();
    }

    header('location: ./admin.php?page=comment');
}

if (isset($_POST['add'])) {
    if ($_POST['table'] == 'post') {
        $user_id = trim($_POST['user_id']);
        $title = trim($_POST['title']);
        $des = trim($_POST['des']);
        $category_id = trim($_POST['category']);

        $thumbnail = $_FILES['thumbnail'];
        $thumbnail_type = explode('.', $thumbnail['name'])[1];
        $thumbnail_name = explode('.', $thumbnail['name'])[0] . '_' . time() . '.' . $thumbnail_type;
        if (move_uploaded_file($thumbnail['tmp_name'], '../uploads/thumbnails/' . $thumbnail_name))
            $thumbnail = $thumbnail_name;
        else $thumbnail = '';
        $result = new \Wlog\Model\Post();
        $result->user_id = $user_id;
        $result->title = $title;
        $result->thumbnail = $thumbnail;
        $result->des = $des;
        $result->category_id = $category_id;
    }
    if ($_POST['table'] == 'category') {
        $name = trim($_POST['name']);
        $sub_cat_id = trim($_POST['subcat']);
        $result = new \Wlog\Model\Category;
        $result->name = $name;
        $result->subcat_id = $sub_cat_id;
    }
    $result->save();
    header('location: ./admin.php?page=' . $_POST['table']);
}

if (isset($_GET['delete']) && isset($_GET['page'])) {
    if ($_GET['page'] == 'user') {
        (\Wlog\Model\User::find($_GET['delete']))->delete();
        header('location:./admin.php?page=user');
    }
    if ($_GET['page'] == 'post') {
        $del_post = \Wlog\Model\Post::find($_GET['delete']);
        if (file_exists('../uploads/thumbnails/' . $del_post->thumbnail))
            unlink('../uploads/thumbnails/' . $del_post->thumbnail);
        $del_post->delete();
        header('location:./admin.php?page=post');
    }
    if ($_GET['page'] == 'category') {
        (\Wlog\Model\Category::find($_GET['delete']))->delete();
        header('location:./admin.php?page=category');
    }
    if ($_GET['page'] == 'comment') {
        $del_comment = \Wlog\Model\Comment::find($_GET['delete']);
        $del_sub_comment = \Wlog\Model\Comment::where('reply', $del_comment->id);
        if (count($del_sub_comment->get()) > 0) {
            $del_three_sub_comment = [];
            foreach ($del_sub_comment->get() as $comment) {
                $del_three_sub_comment[] = \Wlog\Model\Comment::where('reply', $comment->id)->get();
                if (count($del_three_sub_comment) > 0) {
                    foreach ($del_three_sub_comment[0] as $sub_comment) {
                        $sub_comment->delete();
                    }
                }
                $comment->delete();
            }
        }
        $del_comment->delete();
        header('location:./admin.php?page=comment');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>پنل ادمین</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="dist/css/custom-style.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Main Sidebar Container -->
    <?php include_once 'sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 100vh">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <?php if (!isset($page)) : ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-info-active">
                                    <h3 class="widget-user-username" style="text-align: center"><?= $user->name ?></h3>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="../uploads/avatars/<?= $user->avatar ?>"
                                         alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-left">
                                            <div class="description-block">
                                                <h5 class="description-header">ایمیل</h5>
                                                <span><?= $user->email ?></span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 border-left">
                                            <div class="description-block">
                                                <h5 class="description-header">نام کاربری</h5>
                                                <span><?= $user->username ?></span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">نقش</h5>
                                                <span>ادمین</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">ویرایش</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input name="table" required type="hidden" value="user"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input name="id" required type="hidden"
                                                   value="<?= $user->id ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input name="role" required type="hidden"
                                                   value="admin" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">نام</label>
                                            <input name="name" required type="text"
                                                   value="<?= $user->name ?>"
                                                   class="form-control"
                                                   placeholder="نام را وارد کنید">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">نام کاربری</label>
                                            <input name="username" required type="text"
                                                   value="<?= $user->username ?>"
                                                   class="form-control" id="exampleInputPassword1"
                                                   placeholder="نام کاربری را وارد کنید">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">ایمیل</label>
                                            <input name="email" required type="email"
                                                   value="<?= $user->email ?>"
                                                   class="form-control" id="exampleInputPassword1"
                                                   placeholder="ایمیل را وارد کنید">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">تغییر رمز عبور</label>
                                            <input name="password" type="password"
                                                   class="form-control" id="exampleInputPassword1"
                                                   placeholder="تغییر رمز عبور">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button name="edit" type="submit"
                                                class="btn btn-primary">ویرایش
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($page == 'user'): ?>
                        <?php
                        if (isset($_GET['role'])) $role = $_GET['role']; else $role = ['user', 'writer', 'admin'];

                        if (isset($_GET['index'])) $offset = ($_GET['index'] - 1) * 4; else $offset = 0;
                        $users = \Wlog\Model\User::where('role', $role);
                        if (isset($_GET['word'])) {
                            $users->where('username', 'like', '%' . $_GET['word'] . '%');
                        }
                        $users = $users->limit(4)->offset($offset)->orderBy('id', 'desc')->get();
                        if (isset($_GET['word'])) {
                            $user_count = \Wlog\Model\User::where('username', 'like', '%' . $_GET['word'] . '%')->where('role', $role)->get()->count();
                        } else
                            $user_count = \Wlog\Model\User::where('role', $role)->count();

                        $index_count = ceil($user_count / 4);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <?php if (isset($_GET['edit']) && isset($_GET['page'])):
                                        $edit_user = \Wlog\Model\User::find($_GET['edit']);
                                        if (!$edit_user)
                                            header('location: ./admin.php?page=user');
                                        ?>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">ویرایش کاربر</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form role="form" method="post">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input name="table" required type="hidden" value="user"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="id" required type="hidden"
                                                               value="<?= $edit_user->id ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">نام</label>
                                                        <input name="name" required type="text"
                                                               value="<?= $edit_user->name ?>"
                                                               class="form-control"
                                                               placeholder="نام را وارد کنید">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">نام کاربری</label>
                                                        <input name="username" required type="text"
                                                               value="<?= $edit_user->username ?>"
                                                               class="form-control" id="exampleInputPassword1"
                                                               placeholder="نام کاربری را وارد کنید">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">ایمیل</label>
                                                        <input name="email" required type="email"
                                                               value="<?= $edit_user->email ?>"
                                                               class="form-control" id="exampleInputPassword1"
                                                               placeholder="ایمیل را وارد کنید">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">نقش</label>
                                                        <select class="form-control" name="role">
                                                            <option
                                                                <?= $edit_user && $edit_user->role == 'user' ? 'selected' : '' ?>value="user">
                                                                کاربر
                                                            </option>
                                                            <option
                                                                <?= $edit_user && $edit_user->role == 'writer' ? 'selected' : '' ?> value="writer">
                                                                نویسنده
                                                            </option>
                                                            <option
                                                                <?= $edit_user && $edit_user->role == 'admin' ? 'selected' : '' ?> value="admin">
                                                                ادمین
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <?php if ($edit_user->role == 'writer'): ?>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">دسترسی</label>
                                                        <select class="form-control" name="acc_lvl">
                                                            <option
                                                                <?= $edit_user && $edit_user->acc_lvl == 0 ? 'selected' : '' ?>value="0">
                                                                بسته
                                                            </option>
                                                            <option
                                                                <?= $edit_user && $edit_user->acc_lvl > 0 ? 'selected' : '' ?> value="1">
                                                                آزاد
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button name="edit" type="submit"
                                                            class="btn btn-primary">ویرایش
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-header">
                                            <h3 class="card-title">کاربران
                                                <a href="<?= get_url('role') . 'role=user' ?>"
                                                   class="btn btn-<?php if (isset($_GET['role']) && $_GET['role'] == 'user') echo 'secondary'; elseif (!isset($_GET['role'])) echo 'secondary'; else echo 'primary'; ?> text-white">کاربر</a>
                                                <a href="<?= get_url('role') . 'role=writer' ?>"
                                                   class="btn btn-<?= isset($_GET['role']) && $_GET['role'] == 'writer' ? 'secondary' : 'primary' ?> text-white mx-2">نویسنده</a>
                                                <a href="<?= get_url('role') . 'role=admin' ?>"
                                                   class="btn btn-<?= isset($_GET['role']) && $_GET['role'] == 'admin' ? 'secondary' : 'primary' ?> text-white">ادمین</a>
                                            </h3>
                                            <!--search-->
                                            <div class="card-tools">
                                                <form method="get" class="input-group-append">
                                                    <input type="text" name="word" value="<?= $_GET['word'] ?? '' ?>"
                                                           class="form-control float-right"
                                                           placeholder="جستجو در نام کاربری">
                                                    <input type="hidden" name="page" value="<?= $_GET['page'] ?? '' ?>"
                                                           class="form-control float-right">
                                                    <input type="hidden" name="index"
                                                           value="<?= $_GET['index'] ?? '1' ?>"
                                                           class="form-control float-right">
                                                    <input type="hidden" name="role"
                                                           value="<?= $_GET['role'] ?? 'user' ?>"
                                                           class="form-control float-right">
                                                    <button type="submit" name="search" class="btn btn-default"><i
                                                                class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if (count($users) > 0): ?>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th><?= $user_count ?></th>
                                                        <th>نام</th>
                                                        <th>نام کاربری</th>
                                                        <th>ایمیل</th>
                                                        <th>نقش</th>
                                                        <th>تاریخ عضویت</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                    <?php foreach ($users as $index => $user) : ?>
                                                        <tr>
                                                            <td><?= isset($_GET['index']) ? 4 * ($_GET['index'] - 1) + ($index + 1) : $index + 1 ?></td>
                                                            <td><?= $user->name ?></td>
                                                            <td><?= $user->username ?></td>
                                                            <td><?= $user->email ?></td>
                                                            <td>
                                                                <span class="p-2 badge badge-<?= $user->role == 'user' ? 'success' : 'primary' ?>"><?php if ($user->role == 'user') echo 'کاربر'; elseif ($user->role == 'writer') echo 'نویسنده'; elseif ($user->role == 'admin') echo 'ادمین'; ?></span>
                                                            </td>
                                                            <td><?= jdate('Y-m-d', strtotime($user->created_at)) ?></td>
                                                            <td>
                                                                <a href="<?= get_url('edit') . 'edit=' . $user->id ?>"
                                                                   class="btn btn-primary mx-2">ویرایش</a>
                                                                <a href="<?= get_url('delete') . 'delete=' . $user->id ?>"
                                                                   class="btn btn-danger">حذف</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                            <div class="card-footer clearfix">
                                                <ul class="pagination pagination-sm m-0 float-right">
                                                    <?php for ($i = 0; $i < $index_count; $i++): ?>
                                                        <li class="page-item <?php if (isset($_GET['index']) && $_GET['index'] == $i + 1) echo 'active'; elseif (!isset($_GET['index']) && $i + 1 == 1) echo 'active' ?>">
                                                            <a class="page-link"
                                                               href="<?= get_url('index') . 'index=' . $i + 1 ?>"><?= $i + 1 ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-danger mx-3">کاربر مورد نظر یافت نشد!</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <a href="excel_export.php" class="btn btn-primary">خروجی اکسل (excel) از تمام کاربران</a>
                            </div>
                        </div>
                    <?php elseif ($page == 'post'): ?>
                        <?php
                        if (isset($_GET['search'])) {
                            if (isset($_GET['word']))
                                $word = htmlspecialchars(trim($_GET['word']));
                        } else
                            $word = '';

                        if (isset($_GET['index'])) $offset = ($_GET['index'] - 1) * 2; else $offset = 0;
                        $posts = Post::where('id', '!=', 0);
                        $date = $_GET['date'] ?? false;
                        $order = $_GET['order'] ?? false;
                        if ($date) {
                            list($year, $month, $day) = explode('-', $date);
                            $jdate = jalali_to_gregorian($year, $month, $day);
                            $jdate = implode('-', $jdate);
                            $jdate = DateTime::createFromFormat('Y-n-j', $jdate)->format('Y-m-d');
                        }
                        //process like and comment count
                        if ($order == 'like')
                            $posts = Post::leftJoin('post_likes', 'posts.id', '=', 'post_likes.post_id')->select('posts.*')->selectRaw('COUNT(post_likes.id) as like_count')->groupBy('posts.id');
                        else
                            $posts = Post::where('id', '!=', '0');
                        //date
                        if ($date)
                            $posts = $posts->whereDate('posts.created_at', $jdate);

                        $posts = $posts->where('title', 'like', '%' . $word . '%');
                        $posts = $posts->limit(2)->offset($offset);

                        //order
                        if ($order == 'view')
                            $posts = $posts->orderBy('view', 'desc');
                        else if ($order == 'like')
                            $posts = $posts->orderBy('like_count', 'desc');
                        else
                            $posts = $posts->orderBy('posts.updated_at', 'desc');
                        $posts = $posts->get();
                        $post_count = Post::where('id', '!=', '0');
                        if (isset($_GET['word'])) {
                            $post_count = $post_count->where('title', 'like', '%' . $word . '%');
                        }
                        if ($date)
                            $post_count = $post_count->whereDate('posts.created_at', $jdate);
                        $post_count = $post_count->get()->count();
                        $index_count = ceil($post_count / 2);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <?php if ((isset($_GET['edit']) || isset($_GET['add'])) && isset($_GET['page'])):
                                        if (isset($_GET['edit']))
                                            $edit_post = \Wlog\Model\Post::find($_GET['edit']);
                                        else
                                            $edit_post = false
                                        ?>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><?= $edit_post ? 'ویرایش پست' : 'ایجاد پست' ?></h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form role="form" method="post" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input name="table" required type="hidden" value="post"
                                                               class="form-control"
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="id" required type="hidden"
                                                               value="<?= $edit_post ? $edit_post->id : '' ?>"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="user_id" required type="hidden"
                                                               value="<?= $_SESSION['user_id'] ?>"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">عنوان</label>
                                                        <input name="title" required type="text"
                                                               value="<?= $edit_post ? $edit_post->title : '' ?>"
                                                               class="form-control"
                                                               placeholder="عنوان را وارد کنید">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">کاور</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input name="thumbnail" type="file"
                                                                       class="custom-file-input" id="exampleInputFile">
                                                                <label class="custom-file-label" for="exampleInputFile">انتخاب
                                                                    فایل</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="">Upload</span>
                                                            </div>
                                                        </div>
                                                        <?php if ($edit_post && $edit_post->thumbnail) : ?>
                                                            <img class="mt-2" width="200" height="150"
                                                                 src="../uploads/thumbnails/<?= $edit_post->thumbnail ?>"
                                                                 alt="cover">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">توضیحات</label>
                                                        <div class="input-group">
                                                            <textarea rows="10" name="des"
                                                                      style="width: 100%;"><?= $edit_post ? $edit_post->des : 'توضیحات را وارد کنید' ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php $categories = \Wlog\Model\Category::all(); ?>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">دسته بندی</label>
                                                        <select class="form-control" name="category">
                                                            <?php foreach ($categories as $category) : ?>
                                                                <option <?= $edit_post && $edit_post->category_id == $category->id ? 'selected' : '' ?>
                                                                        value="<?= $category->id ?>"><?= $category->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button name="<?= $edit_post ? 'edit' : 'add' ?>" type="submit"
                                                            class="btn btn-primary"><?= $edit_post ? 'ویرایش' : 'ایجاد' ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-header">
                                            <h3 class="card-title">پست ها
                                                <a href="<?= get_url('order') . 'order=view' ?>"
                                                   class="btn btn-<?= isset($_GET['order']) && $_GET['order'] == 'view' ? 'secondary' : 'primary' ?> mx-2">پر
                                                    بازدید</a>
                                                <a href="<?= get_url('order') . 'order=like' ?>"
                                                   class="btn btn-<?= isset($_GET['order']) && $_GET['order'] == 'like' ? 'secondary' : 'primary' ?>">محبوب</a>
                                                <form method="get" class="d-inline mx-2">
                                                    <input name="date" style="width: 150px; display: inline"
                                                           class="form-control"
                                                           type="text" value="<?= $_GET['date'] ?? '' ?>"
                                                           placeholder="<?= jdate('Y-m-d') ?>">
                                                    <input name="word" class="form-control" type="hidden"
                                                           value="<?= $word ?>">
                                                    <input name="index" type="hidden"
                                                           value="<?= $_GET['index'] ?? '1' ?>"
                                                           class="form-control float-right">
                                                    <input name="page" type="hidden" value="<?= $_GET['page'] ?? '' ?>"
                                                           class="form-control float-right">
                                                    <input name="order" class="form-control" type="hidden"
                                                           value="<?= $_GET['order'] ?? '' ?>">
                                                    <button name="search" class="btn btn-primary me-1" type="submit">
                                                        اعمال
                                                    </button>
                                                </form>
                                                <a href="<?= get_url('date') ?>date=<?= jdate('Y-m-d', tr_num: 'en') ?>"
                                                   class=" btn btn-<?= isset($_GET['date']) && $_GET['date'] == jdate('Y-m-d', tr_num: 'en') ? 'secondary' : 'primary' ?> me-2"
                                                   type="text">امروز</a>
                                            </h3>
                                            <!--search-->
                                            <div class="card-tools">
                                                <form method="get" class="input-group-append">
                                                    <input type="text" name="word" class="form-control float-right"
                                                           value="<?= $word ?>"
                                                           placeholder="جستجو">
                                                    <input name="date" style="width: 150px; display: inline"
                                                           class="form-control"
                                                           type="hidden" value="<?= $_GET['date'] ?? '' ?>"
                                                           placeholder="<?= jdate('Y-m-d') ?>">
                                                    <input name="index" type="hidden"
                                                           value="<?= $_GET['index'] ?? '1' ?>"
                                                           class="form-control float-right">
                                                    <input name="page" type="hidden" value="<?= $_GET['page'] ?? '' ?>"
                                                           class="form-control float-right">
                                                    <input name="order" class="form-control" type="hidden"
                                                           value="<?= $_GET['order'] ?? '' ?>">
                                                    <button name="search" type="submit" class="btn btn-default"><i
                                                                class="fa fa-search"></i>
                                                    </button>

                                                    <a href="./admin.php?page=post&add=" class="btn btn-primary"
                                                       style="margin-right: 100px"> پست
                                                        جدید <i class="fa fa-plus pt-1"></i></a>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if (count($posts) > 0): ?>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th><?= $post_count ?></th>
                                                        <th>تصویر</th>
                                                        <th>عنوان</th>
                                                        <th>نویسنده</th>
                                                        <th>دسته بندی</th>
                                                        <th>بازدید</th>
                                                        <th>لایک</th>
                                                        <th>کامنت</th>
                                                        <th>متن</th>
                                                        <th>تاریخ ایجاد</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                    <?php foreach ($posts as $index => $post): ?>
                                                        <tr>
                                                            <td><?= isset($_GET['index']) ? 2 * ($_GET['index'] - 1) + ($index + 1) : $index + 1 ?></td>
                                                            <td><img src="../uploads/thumbnails/<?= $post->thumbnail ?>"
                                                                     width="50px" alt="cover"></td>
                                                            <td><a href="../single.php?id=<?= $post->id ?>"
                                                                   style="color: black"><?= mb_substr(explode(':', $post->title)[0], 0, 10) ?></a>
                                                            </td>
                                                            <td><?= \Wlog\Model\User::find($post->user_id)->name ?></td>
                                                            <td><?= \Wlog\Model\Category::find($post->category_id)->name ?></td>
                                                            <td><?= $post->view ?></td>
                                                            <td><?= \Wlog\Model\PostLike::where('post_id', $post->id)->count() ?></td>
                                                            <td><?= \Wlog\Model\Comment::where('post_id', $post->id)->count() ?></td>
                                                            <td><?= mb_substr($post->des, 0, 20) . '...' ?></td>
                                                            <td><?= jdate('Y-m-d', strtotime($post->created_at)) ?></td>
                                                            <td>
                                                                <a href="<?= get_url('edit') . 'edit=' . $post->id ?>"
                                                                   class="btn btn-primary mx-2">ویرایش</a>
                                                                <a href="<?= get_url('delete') . 'delete=' . $post->id ?>"
                                                                   class="btn btn-danger">حذف</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                            <div class="card-footer clearfix">
                                                <ul class="pagination pagination-sm m-0 float-right">
                                                    <?php for ($i = 0; $i < $index_count; $i++): ?>
                                                        <li class="page-item <?php if (isset($_GET['index']) && $_GET['index'] == $i + 1) echo 'active'; elseif (!isset($_GET['index']) && $i + 1 == 1) echo 'active' ?>">
                                                            <a class="page-link"
                                                               href="<?= get_url('index') . 'index=' . $i + 1 ?>"><?= $i + 1 ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-danger mx-3">پست مورد نظر یافت نشد!</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif
                    ($page == 'category'): ?>
                        <?php
                        $categories = \Wlog\Model\Category::where('id', '!=', 0)->orderBy('created_at', 'desc')->get();
                        $category_count = count($categories);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">دسته بندی ها</h3>
                                        <div class="card-tools">
                                            <form method="get" class="input-group-append">
                                                <a href="./admin.php?page=category&add=" class="btn btn-primary"
                                                   style="margin-right: 100px"> دسته
                                                    بندی جدید <i class="fa fa-plus pt-1"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <?php if ((isset($_GET['edit']) || isset($_GET['add'])) && isset($_GET['page'])):
                                        if (isset($_GET['edit']))
                                            $edit_category = \Wlog\Model\Category::find($_GET['edit']);
                                        else
                                            $edit_category = false
                                        ?>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><?= $edit_category ? 'ویرایش دسته بندی' : 'ایجاد دسته بندی' ?></h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form role="form" method="post" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input name="table" required type="hidden" value="category"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="id" required type="hidden"
                                                               value="<?= $edit_category ? $edit_category->id : '' ?>"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="name" required type="text"
                                                               value="<?= $edit_category ? $edit_category->name : '' ?>"
                                                               class="form-control"
                                                               placeholder="نام دسته بندی را وارد کنید">
                                                    </div>
                                                    <?php $categories = \Wlog\Model\Category::all(); ?>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">زیر دسته بندی</label>
                                                        <select class="form-control" name="subcat">
                                                            <option value="0" <?= $edit_category && $edit_category->subcat_id ? 'selected' : '' ?>>
                                                                اصلی
                                                            </option>
                                                            <?php foreach ($categories as $category) : ?>
                                                                <?php if ($category->subcat_id == 0) : ?>
                                                                    <option <?= $edit_category && $edit_category->subcat_id == $category->id ? 'selected' : '' ?>
                                                                            value="<?= $category->id ?>"><?= $category->name ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button name="<?= $edit_category ? 'edit' : 'add' ?>" type="submit"
                                                            class="btn btn-primary"><?= $edit_category ? 'ویرایش' : 'ایجاد' ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover">
                                                <tr>
                                                    <th><?= $category_count ?></th>
                                                    <th>نام</th>
                                                    <th>زیر دسته بندی</th>
                                                    <th>تعداد پست</th>
                                                    <th>تاریخ ایجاد</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                <?php foreach ($categories as $index => $category): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= $category->name ?></td>
                                                        <td><span class="badge badge-<?= $category->subcat_id > 0 ? 'danger' : 'primary' ?>">
                                                        <?= $category->subcat_id > 0 ? \Wlog\Model\Category::find($category->subcat_id)->name : 'اصلی' ?>
                                                    </span></td>
                                                        <td><a class="badge badge-primary px-2" href="../cat.php?id=<?= $category->id ?>"><?= Post::where('category_id', $category->id)->count(); ?></a></td>
                                                        <td><?= jdate('Y-m-d', strtotime($category->created_at)) ?></td>
                                                        <td>
                                                            <a href="<?= get_url('edit') . 'edit=' . $category->id ?>"
                                                               class="btn btn-primary mx-2">ویرایش</a>
                                                            <a href="<?= get_url('delete') . 'delete=' . $category->id ?>"
                                                               class="btn btn-danger">حذف</a>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($page == 'comment'): ?>
                        <?php
                        if (isset($_GET['search'])) {
                            if (isset($_GET['word']))
                                $word = htmlspecialchars(trim($_GET['word']));
                        } else
                            $word = '';

                        if (isset($_GET['index'])) $offset = ($_GET['index'] - 1) * 5; else $offset = 0;
                        $comments = \Wlog\Model\Comment::where('id', '!=', 0);
                        $date = $_GET['date'] ?? false;
                        $status = $_GET['status'] ?? false;
                        if ($date) {
                            list($year, $month, $day) = explode('-', $date);
                            $jdate = jalali_to_gregorian($year, $month, $day);
                            $jdate = implode('-', $jdate);
                            $jdate = DateTime::createFromFormat('Y-n-j', $jdate)->format('Y-m-d');
                        }
                        if ($date)
                            $comments = $comments->whereDate('created_at', $jdate);

                        $comments = $comments->where('content', 'like', '%' . $word . '%');
                        $comments = $comments->limit(5)->offset($offset);

                        if ($status == 'accept')
                            $comments = $comments->where('status', 1);
                        else if ($status == 'de-accept')
                            $comments = $comments->where('status', -1);
                        else if ($status == 'none-accept')
                            $comments = $comments->where('status', 0);
                        $comments = $comments->orderBy('updated_at', 'desc');

                        $comments = $comments->get();
                        $comment_count = \Wlog\Model\Comment::where('id', '!=', '0');
                        if (isset($_GET['word'])) {
                            $comment_count = $comment_count->where('content', 'like', "%$word%");
                        }
                        if ($date)
                            $comment_count = $comment_count->whereDate('created_at', $jdate);
                        $comment_count = $comment_count->get()->count();
                        $index_count = ceil($comment_count / 5);
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <?php if (isset($_GET['reply']) && isset($_GET['page'])): ?>
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">پاسخ به کامنت</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form role="form" method="post" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <input name="table" required type="hidden" value="comment"
                                                               class="form-control"
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="user_id" required type="hidden"
                                                               value="<?= $_SESSION['user_id'] ?>"
                                                               class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">متن</label>
                                                        <input name="content" required type="text"
                                                               class="form-control"
                                                               placeholder="متن پاسخ را وارد کنید">
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button name="reply" value="<?= $_GET['reply'] ?>" type="submit"
                                                            class="btn btn-primary">پاسخ
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-header">
                                            <h3 class="card-title">کامنت ها
                                                <form method="get" class="mx-2" style="display: inline">
                                                    <form method="get" class="d-inline mx-2">
                                                        <input name="date" style="width: 150px; display: inline"
                                                               class="form-control" type="text"
                                                               value="<?= $_GET['date'] ?? '' ?>"
                                                               placeholder="<?= jdate('Y-m-d') ?>">
                                                        <input name="word" class="form-control" type="hidden"
                                                               value="<?= $word ?>">
                                                        <input name="index" type="hidden"
                                                               value="<?= $_GET['index'] ?? '1' ?>"
                                                               class="form-control float-right">
                                                        <input name="page" type="hidden"
                                                               value="<?= $_GET['page'] ?? '' ?>"
                                                               class="form-control float-right">
                                                        <input name="order" class="form-control" type="hidden"
                                                               value="<?= $_GET['order'] ?? '' ?>">
                                                        <button name="search" class="btn btn-primary me-1"
                                                                type="submit">
                                                            اعمال
                                                        </button>
                                                        <a href="<?= get_url('date') ?>date=<?= jdate('Y-m-d', tr_num: 'en') ?>"
                                                           class=" btn btn-<?= isset($_GET['date']) && $_GET['date'] == jdate('Y-m-d', tr_num: 'en') ? 'secondary' : 'primary' ?> mx-2"
                                                           type="text">امروز</a>

                                                        <a href="<?= get_url('status') . 'status=none-accept' ?>"
                                                           class="btn btn-<?= isset($_GET['status']) && $_GET['status'] == 'none-accept' ? 'secondary' : 'primary' ?>">تایید
                                                            نشده</a>
                                                        <a href="<?= get_url('status') . 'status=accept' ?>"
                                                           class="btn btn-<?= isset($_GET['status']) && $_GET['status'] == 'accept' ? 'secondary' : 'primary' ?> mx-2">تایید
                                                            شده</a>
                                                        <a href="<?= get_url('status') . 'status=de-accept' ?>"
                                                           class="btn btn-<?= isset($_GET['status']) && $_GET['status'] == 'de-accept' ? 'secondary' : 'primary' ?>">رد
                                                            شده</a>

                                                    </form>
                                            </h3>
                                            <!--search-->
                                            <div class="card-tools">
                                                <form method="get" class="input-group-append">
                                                    <input type="text" name="word" class="form-control float-right"
                                                           value="<?= $word ?>"
                                                           placeholder="جستجو">
                                                    <input name="date" style="width: 150px; display: inline"
                                                           class="form-control"
                                                           type="hidden" value="<?= $_GET['date'] ?? '' ?>"
                                                           placeholder="<?= jdate('Y-m-d') ?>">
                                                    <input name="index" type="hidden"
                                                           value="<?= $_GET['index'] ?? '1' ?>"
                                                           class="form-control float-right">
                                                    <input name="page" type="hidden" value="<?= $_GET['page'] ?? '' ?>"
                                                           class="form-control float-right">
                                                    <input name="order" class="form-control" type="hidden"
                                                           value="<?= $_GET['order'] ?? '' ?>">
                                                    <button name="search" type="submit" class="btn btn-default"><i
                                                                class="fa fa-search"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if (count($comments) > 0): ?>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th><?= $comment_count ?></th>
                                                        <th>کاربر</th>
                                                        <th>پست</th>
                                                        <th>متن</th>
                                                        <th>پاسخ</th>
                                                        <th>تاریخ ایجاد</th>
                                                        <th>وضعیت</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                    <?php
                                                    $is_tree_sub_comments = [];
                                                    foreach ($comments as $comment) {
                                                        $sub_comments = \Wlog\Model\Comment::where('reply', $comment->id)->get();
                                                        if ($sub_comments->isNotEmpty()) {
                                                            foreach ($sub_comments as $sub_comment) {
                                                                $tree_sub_comments = (\Wlog\Model\Comment::where('reply', $sub_comment->id));
                                                                if ($tree_sub_comments->count() > 0) {
                                                                    $is_tree_sub_comments[] = ($tree_sub_comments->get())[0]->id;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    foreach ($comments as $index => $comment):?>
                                                        <tr>
                                                            <td><?= isset($_GET['index']) ? 5 * ($_GET['index'] - 1) + ($index + 1) : $index + 1 ?></td>
                                                            <td><?= \Wlog\Model\User::find($comment->user_id)->username ?></td>
                                                            <td><?php $comment_post = Post::find($comment->post_id); ?>
                                                                <a target="_blank"
                                                                   href="../single.php?id=<?= $comment_post->id ?>"
                                                                   style="color: black">
                                                                    <?= mb_substr(explode(':', $comment_post->title)[0], 0, 50) ?>
                                                                </a>
                                                            </td>
                                                            <td><?= mb_substr($comment->content, 0, 10) . '...' ?></td>
                                                            <td><?= $comment->reply > 0 ? \Wlog\Model\User::find(\Wlog\Model\Comment::find($comment->reply)->user_id)->username : 'اصلی' ?></td>
                                                            <td><?= jdate('Y-m-d', strtotime($comment->created_at)) ?></td>
                                                            <?php if ($comment->status == 1): ?>
                                                                <td><a class="btn btn-success text-white" href="<?= get_url('reject') . 'reject=' . $comment->id ?>">تایید شده</a></td>
                                                            <?php elseif ($comment->status == -1): ?>
                                                                <td><a class="btn btn-danger" href="<?= get_url('approve') . 'approve=' . $comment->id ?>">رد شده</a></td>
                                                            <?php elseif ($comment->status == 0): ?>
                                                                <td>
                                                                    <a class="btn btn-success" href="<?= get_url('approve') . 'approve=' . $comment->id ?>">تایید</a>
                                                                    <a class="btn btn-danger" href="<?= get_url('reject') . 'reject=' . $comment->id ?>">رد</a>
                                                                </td>
                                                            <?php endif; ?>
                                                            <td>
                                                                <?php if (!in_array($comment->id, $is_tree_sub_comments)): ?>
                                                                    <a href="<?= get_url('reply') . "reply=$comment->id" ?>"
                                                                       class="btn btn-success">پاسخ</a>
                                                                <?php else: ?>
                                                                    <span class="btn btn-secondary text-white">پاسخ</span>
                                                                <?php endif; ?>
                                                                <a href="<?= get_url('delete') . 'delete=' . $comment->id ?>"
                                                                   class="btn btn-danger">حذف</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                            <div class="card-footer clearfix">
                                                <ul class="pagination pagination-sm m-0 float-right">
                                                    <?php for ($i = 0; $i < $index_count; $i++): ?>
                                                        <li class="page-item <?php if (isset($_GET['index']) && $_GET['index'] == $i + 1) echo 'active'; elseif (!isset($_GET['index']) && $i + 1 == 1) echo 'active' ?>">
                                                            <a class="page-link"
                                                               href="<?= get_url('index') . 'index=' . $i + 1 ?>"><?= $i + 1 ?></a>
                                                        </li>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-danger mx-3">کامنت مورد نظر یافت نشد!</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
<?php include_once 'footer.php' ?>
