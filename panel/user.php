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

if ($user->role != 'user')
    header("location:./index.php");
function get_url($key)
{
    $url = 'user.php?';
    foreach ($_GET as $index => $val) {
        if ($index == $key) {
            continue;
        }
        $url .= "$index=$val&";
    }
    return $url;
}

if (isset($_POST['edit'])) {
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
    header('location:./user.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>پنل کاربر</title>

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

    <div class="content-header"style="min-height: 100vh">
        <div class="container-fluid">
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
                                    <div class="col-sm-4 border-left">
                                        <div class="description-block">
                                            <a href="<?= $user->role ?>.php?logout=<?= $user->id ?>" class="btn btn-danger">خروج</a>
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
                                        <input name="id" required type="hidden"
                                               value="<?= $user->id ?>" class="form-control">
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
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <?php
                                    $like_posts = \Wlog\Model\PostLike::where('user_id', $_SESSION['user_id'])->get();
                                    $like_posts_id = [];
                                    foreach ($like_posts as $post) {
                                        $like_posts_id[] = $post->post_id;
                                    }
                                    $posts = Post::whereIn('id', $like_posts_id)->get();
                                    $post_count = $posts->count();
                                    $index_count = ceil($post_count / 2);
                                    ?>
                                    <?php if (count($posts) > 0): ?>
                                    <div class="card-body table-responsive p-0">
                                        <p style="font-size: 24px;font-weight: bold">پست هایی که لایک کردید</p>
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
                                            </tr>
                                            <?php foreach ($posts as $index => $post): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
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
                                                <td><?= mb_substr($post->des, 0, 40) . '...' ?></td>
                                                <td><?= jdate('Y-m-d', strtotime($post->created_at)) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="alert alert-danger mx-3">پستی یافت نشد!</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <?php
                                    $comments = \Wlog\Model\Comment::where('user_id', $_SESSION['user_id'])->get();
                                    $comments_count = $comments->count();
                                    ?>
                                        <?php if (count($comments) > 0): ?>
                                            <div class="card-body table-responsive p-0">
                                                <p style="font-size: 24px;font-weight: bold">کامنت های شما</p>
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th><?= $comments_count ?></th>
                                                        <th>پست</th>
                                                        <th>متن</th>
                                                        <th>پاسخ</th>
                                                        <th>تاریخ ایجاد</th>
                                                        <th>وضعیت</th>
                                                    </tr>
                                                    <?php foreach ($comments as $index => $comment):?>
                                                        <tr>
                                                            <td><?= $index + 1 ?></td>
                                                            <td><?php $comment_post = Post::find($comment->post_id); ?>
                                                                <a target="_blank"
                                                                   href="../single.php?id=<?= $comment_post->id ?>"
                                                                   style="color: black">
                                                                    <?= mb_substr(explode(':', $comment_post->title)[0], 0, 100) ?>
                                                                </a>
                                                            </td>
                                                            <td><?= mb_substr($comment->content, 0, 40) . '...' ?></td>
                                                            <td><?= $comment->reply > 0 ? \Wlog\Model\User::find(\Wlog\Model\Comment::find($comment->reply)->user_id)->username : 'اصلی' ?></td>
                                                            <td><?= jdate('Y-m-d', strtotime($comment->created_at)) ?></td>
                                                            <?php if ($comment->status == 1): ?>
                                                            <td class="text-success">تایید شده</td>
                                                            <?php elseif ($comment->status == -1): ?>
                                                            <td class="text-danger">رد شده</td>
                                                            <?php elseif ($comment->status == 0): ?>
                                                            <td class="text-info">در انتظار تایید</td>
                                                            <?php endif; ?>

                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-danger mx-3">کامنت مورد نظر یافت نشد!</div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div><!-- /.container-fluid -->

</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
<?php include_once 'footer.php' ?>
