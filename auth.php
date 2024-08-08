<?php
session_start();
if (isset($_SESSION['user_id']))
    header('location: index.php');
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="description"
          content=" Today in this blog you will learn how to create a responsive Login & Registration Form in HTML CSS & JavaScript. The blog will cover everything from the basics of creating a Login & Registration in HTML, to styling it with CSS and adding with JavaScript."/>
    <meta
            name="keywords"
            content="
 Animated Login & Registration Form,Form Design,HTML and CSS,HTML CSS JavaScript,login & registration form,login & signup form,Login Form Design,registration form,Signup Form,HTML,CSS,JavaScript,
"
    />

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AMA Tech | Login</title>
    <link rel="stylesheet" href="assets/css/auth.css"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<section class="wrapper active">
    <div class="form signup">
        <header>ثبت نام</header>
        <form action="action.php" method="post">
            <input type="text" placeholder="نام" required name="name"/>
            <input type="text" placeholder="نام کاربری" required name="username"/>
            <input type="email" placeholder="ایمیل" required name="email">
            <input type="password" placeholder="رمز عبور" required name="password"/>
            <input type="submit" value="ثبت نام" name="signup"/>
        </form>
    </div>

    <div class="form login">
        <header>ورود</header>
        <form action="action.php" method="post">
            <input type="text" placeholder="نام کاربری" name="username" required/>
            <input type="password" placeholder="رمز عبور" required name="password"/>
            <input type="submit" value="ورود" name="signin"/>
        </form>
        <?php if (isset($_GET['err'])):
            if ($_GET['err'] == 'notFindUser') $err = 'نام کاربری یا رمز عبور اشتباه است'; elseif ($_GET['err'] == 'empty') $err = 'لطفا مقدار فیلد ها را درست وارد کنید!'; else $err = 'کاربر موجود است.';
            if ($_GET['err'] == 'exist') $err = 'کاربر موجود است.';?>
            <div style="width: 443px; top: 10px;right: 10px; color: red; margin: 10px"><?= $err ?></div>
        <?php endif; ?>
    </div>

    <script>
        const wrapper = document.querySelector(".wrapper"),
            signupHeader = document.querySelector(".signup header"),
            loginHeader = document.querySelector(".login header");

        loginHeader.addEventListener("click", () => {
            wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
            wrapper.classList.remove("active");
        });
    </script>
</section>
</body>
</html>
