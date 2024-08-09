<?php

use Wlog\Model\Post;

require_once '../init.php';
if (isset($_SESSION['user_id']))
    $user = \Wlog\Model\User::find($_SESSION['user_id']);
else
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">کاربران اخیر</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>شماره</th>
                                            <th>کاربر</th>
                                            <th>تاریخ</th>
                                            <th>وضعیت</th>
                                            <th>دلیل</th>
                                        </tr>
                                        <tr>
                                            <td>183</td>
                                            <td>محمد</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-success">تایید شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>219</td>
                                            <td>حسام</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge bg-danger">در حال بررسی</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>657</td>
                                            <td>رضا</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-primary">تایید شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>175</td>
                                            <td>پرهام</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-danger">رد شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">پست های اخیر</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>شماره</th>
                                            <th>کاربر</th>
                                            <th>تاریخ</th>
                                            <th>وضعیت</th>
                                            <th>دلیل</th>
                                        </tr>
                                        <tr>
                                            <td>183</td>
                                            <td>محمد</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-success">تایید شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>219</td>
                                            <td>حسام</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge bg-danger">در حال بررسی</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>657</td>
                                            <td>رضا</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-primary">تایید شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                        <tr>
                                            <td>175</td>
                                            <td>پرهام</td>
                                            <td>11-7-2014</td>
                                            <td><span class="badge badge-danger">رد شده</span></td>
                                            <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
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
                        $user_count = \Wlog\Model\User::where('username', 'like', '%' . $_GET['word'] . '%')->get()->count();
                    } else
                        $user_count = \Wlog\Model\User::all()->count();

                    $index_count = round($user_count / 4);
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
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
                                            <input type="hidden" name="index" value="<?= $_GET['index'] ?? '1' ?>"
                                                   class="form-control float-right">
                                            <input type="hidden" name="role" value="<?= $_GET['role'] ?? 'user' ?>"
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
                            </div>
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
                        $posts = $posts->orderBy('created_at', 'desc');
                    $posts = $posts->get();
                    if (isset($_GET['word'])) {
                        $post_count = \Wlog\Model\Post::where('title', 'like', '%' . $_GET['word'] . '%')->get()->count();
                    } else
                        $post_count = \Wlog\Model\Post::all()->count();
                    $index_count = round($post_count / 2);
                    ?>
                    <div class="row">
                    <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">پست ها
                            <a href="<?= get_url('order') . 'order=view' ?>"
                               class="btn btn-<?= isset($_GET['order']) && $_GET['order'] == 'view' ? 'secondary' : 'primary' ?> mx-2">پر
                                بازدید</a>
                            <a href="<?= get_url('order') . 'order=like' ?>"
                               class="btn btn-<?= isset($_GET['order']) && $_GET['order'] == 'like' ? 'secondary' : 'primary' ?>">محبوب</a>
                            <form method="get" class="d-inline mx-2">
                                <input name="date" style="width: 150px; display: inline" class="form-control"
                                       type="text" value="<?= $_GET['date'] ?? '' ?>"
                                       placeholder="<?= jdate('Y-m-d') ?>">
                                <input name="word" class="form-control" type="hidden" value="<?= $word ?>">
                                <input name="index" type="hidden" value="<?= $_GET['index'] ?? '1' ?>"
                                       class="form-control float-right">
                                <input name="page" type="hidden" value="<?= $_GET['page'] ?? '' ?>"
                                       class="form-control float-right">
                                <input name="order" class="form-control" type="hidden"
                                       value="<?= $_GET['order'] ?? '' ?>">
                                <button name="search" class="btn btn-primary me-1" type="submit">اعمال</button>
                            </form>
                            <a href="<?= get_url('date') ?>date=<?= jdate('Y-m-d', tr_num: 'en') ?>"
                               class=" btn btn-<?= isset($_GET['date']) && $_GET['date'] == jdate('Y-m-d', tr_num: 'en') ? 'secondary' : 'primary' ?> me-2"
                               type="text">امروز</a>
                        </h3>
                        <!--search-->
                        <div class="card-tools">
                            <form method="get" class="input-group-append">
                                <input type="text" name="word" class="form-control float-right" value="<?= $word ?>"
                                       placeholder="جستجو">
                                <input name="date" style="width: 150px; display: inline" class="form-control"
                                       type="hidden" value="<?= $_GET['date'] ?? '' ?>"
                                       placeholder="<?= jdate('Y-m-d') ?>">
                                <input name="index" type="hidden" value="<?= $_GET['index'] ?? '1' ?>"
                                       class="form-control float-right">
                                <input name="page" type="hidden" value="<?= $_GET['page'] ?? '' ?>"
                                       class="form-control float-right">
                                <input name="order" class="form-control" type="hidden"
                                       value="<?= $_GET['order'] ?? '' ?>">
                                <button name="search" type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                </button>

                                <a href="#" class="btn btn-primary" style="margin-right: 100px"> پست
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
                                </tr>
                                <?php foreach ($posts as $index => $post): ?>
                                    <tr>
                                        <td><?= isset($_GET['index']) ? 2 * ($_GET['index'] - 1) + ($index + 1) : $index + 1 ?></td>
                                        <td><img src="../uploads/thumbnails/<?= $post->thumbnail ?>"
                                                 width="50px" alt="cover"></td>
                                        <td><?= mb_substr(explode(':', $post->title)[0], 0, 100) ?></td>
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
                        </div>
                        </div>
                        </div>
                    <?php elseif ($page == 'category'): ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">دسته بندی ها</h3>
                                        <div class="card-tools">
                                            <form method="get" class="input-group-append">
                                                <a href="#" class="btn btn-primary" style="margin-right: 100px"> دسته
                                                    بندی جدید <i class="fa fa-plus pt-1"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>شماره</th>
                                                <th>کاربر</th>
                                                <th>تاریخ</th>
                                                <th>وضعیت</th>
                                                <th>دلیل</th>
                                            </tr>
                                            <tr>
                                                <td>183</td>
                                                <td>محمد</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-success">تایید شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>219</td>
                                                <td>حسام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge bg-danger">در حال بررسی</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>657</td>
                                                <td>رضا</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-primary">تایید شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($page == 'comment'): ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">کامنت ها
                                            <form method="get" class="mx-2" style="display: inline">
                                                <input style="width: 200px;display: inline" name="date"
                                                       class="form-control" type="text" value=""
                                                       placeholder="<?= jdate('Y-m-d') ?>">
                                                <button name="search" class="btn btn-primary me-1" type="submit">اعمال
                                                </button>
                                                <a href="#" class="btn btn-primary mx-2" type="text">امروز</a>
                                                <a href="#" class="btn btn-primary" style="margin-right: 20px"
                                                   type="text">تایید نشده</a>
                                                <a href="#" class="btn btn-primary mx-2" type="text">تایید شده</a>
                                                <a href="#" class="btn btn-primary" type="text">رد شده</a>
                                            </form>
                                        </h3>
                                        <!--search-->
                                        <div class="card-tools">
                                            <form method="get" class="input-group-append">
                                                <input type="text" name="table_search" class="form-control float-right"
                                                       placeholder="جستجو در پست">
                                                <button type="submit" class="btn btn-default"><i
                                                            class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>شماره</th>
                                                <th>کاربر</th>
                                                <th>تاریخ</th>
                                                <th>وضعیت</th>
                                                <th>دلیل</th>
                                            </tr>
                                            <tr>
                                                <td>183</td>
                                                <td>محمد</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-success">تایید شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>219</td>
                                                <td>حسام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge bg-danger">در حال بررسی</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>657</td>
                                                <td>رضا</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-primary">تایید شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                            <tr>
                                                <td>175</td>
                                                <td>پرهام</td>
                                                <td>11-7-2014</td>
                                                <td><span class="badge badge-danger">رد شده</span></td>
                                                <td>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                                            <li class="page-item"><a class="page-link" href="#">۱</a></li>
                                            <li class="page-item"><a class="page-link" href="#">۲</a></li>
                                            <li class="page-item"><a class="page-link" href="#">۳</a></li>
                                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                                        </ul>
                                    </div>
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
