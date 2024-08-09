<?php
session_start();
if (isset($_SESSION['user_id']))
    header('location: index.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>صفحه ورود</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme style -->
    <link rel="stylesheet" href="panel/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="panel/dist/css/bootstrap-rtl.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>ورود به سایت</b></a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form action="action.php" method="post">
                <div class="input-group mb-3">
                    <input name="username" type="text" class="form-control" placeholder="نام کاربری" required>
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="رمز عبور" required>
                </div>
                <div class="row">
                    <button name="signin" type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
                </div>
                <div class="row mt-2">
                    <a href="register.php" type="submit" class="btn btn-secondary btn-block btn-flat text-white">
                        ثبت نام نکردی؟
                    </a>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    <?php if (isset($_GET['err'])):
        if ($_GET['err'] == 'notFindUser') $err = 'نام کاربری یا رمز عبور اشتباه است'; else $err = 'لطفا مقدار فیلد ها را درست وارد کنید!'; ?>
        <div style=" color: red; margin: 0px 10px;text-align: center"><?= $err ?></div>
    <?php endif; ?>
</div>
</body>
</html>
