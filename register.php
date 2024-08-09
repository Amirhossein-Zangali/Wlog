<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>صفحه ثبت نام</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme style -->
    <link rel="stylesheet" href="panel/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="panel/dist/css/bootstrap-rtl.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <b>ثبت نام در سایت</b>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <form action="action.php" method="post">
                <div class="input-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="نام" required>
                </div>
                <div class="input-group mb-3">
                    <input name="username" type="text" class="form-control" placeholder="نام کاربری" required>
                </div>
                <div class="input-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="ایمیل" required>
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="رمز عبور" required>
                </div>
                <div class="row">
                    <button name="signup" type="submit" class="btn btn-primary btn-block btn-flat">ثبت نام</button>
                </div>
                <div class="row mt-2">
                    <a href="login.php" type="submit" class="btn btn-secondary btn-block btn-flat text-white">قبلا
                        ثبت نام کردی؟</a>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($_GET['err'])):
        if ($_GET['err'] == 'empty') $err = 'لطفا مقدار فیلد ها را درست وارد کنید!'; else $err = 'کاربر موجود است.';?>
        <div style=" color: red; margin: 0px 10px;text-align: center"><?= $err ?></div>
    <?php endif; ?>
</div>
</body>
</html>
