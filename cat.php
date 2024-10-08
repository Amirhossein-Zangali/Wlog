<?php
require_once __DIR__ . '/init.php';

use Wlog\Model\Category;
use Wlog\Model\Comment;
use Wlog\Model\Post;
use Wlog\Model\PostLike;
use Wlog\Model\User;

if (isset($_GET['id'])){
    if (!empty($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET['id'];
    }
}
if (!isset($id))
    header('Location: admin.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Wlog - Blog and Magazine HTML template </title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Blog">
    <meta name="keywords" content="">
    <meta name="author" content="kamleshyadav">
    <meta name="MobileOptimized" content="320">
    <!--Start Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugins/swiper/swiper.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugins/magnific/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- Favicon Link -->
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
</head>
<body dir="rtl">
<div class="blog_main_wrapper">
    <?php include_once 'nav.php';
    $category = Category::find($id);
    if (!$category)
        header('Location: admin.php');
    ?>
    <div class="blog_breadcrumb_wrapper" style="margin-top: 90px">
        <div class="container justify-content-center align-items-center">
            <div class="blog_breadcrumb_div">
                <?php if ($category->subcat_id > 0): $sub_category = Category::find($category->subcat_id);?>
                    <h3><?= $sub_category->name . ' / ' . $category->name ?></h3>
                <?php else: ?>
                    <h3><?= $category->name ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="blog_food_health blog_topheading_slider_nav blog_topheading_style2 blog_innerpages">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="blog_sport_slider">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper" style="min-height: 70vh; width: 100vw">
                                        <?php $posts = Post::where('category_id', $category->id)->get();
                                        $sub_categories = Category::where('subcat_id', $category->id)->get();
                                        foreach ($sub_categories as $sub_category) {
                                            $posts = Post::whereIn('category_id', [$category->id, $sub_category->id])->get();
                                        }
                                        if (count($posts) > 0):
                                        foreach ($posts as $post):?>
                                            <div class="swiper-slide" style="margin-bottom:10px ">
                                                <div class="blog_post_style2">
                                                    <div class="blog_post_style2_img">
                                                        <img src="uploads/thumbnails/<?= $post->thumbnail ?>" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="blog_post_style2_content">
                                                        <h3>
                                                            <a href="single.php?id=<?= $post->id ?>"><?= $post->title ?></a>
                                                            <span style="float: left; display: inline-block"><?= jdate('Y-m-d', strtotime($post->created_at)) ?></span>
                                                        </h3>
                                                        <ul class="blog_meta_tags">
                                                            <li><span class="blog_bg_blue"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="12px"
                                                                            height="7px">
                                                                                    <path fill-rule="evenodd"
                                                                                          fill="rgb(255, 255, 255)"
                                                                                          d="M11.829,3.074 C11.732,2.948 9.422,-0.000 6.468,-0.000 C3.514,-0.000 1.203,2.948 1.106,3.074 C0.916,3.320 0.916,3.678 1.106,3.925 C1.203,4.050 3.514,6.999 6.468,6.999 C9.422,6.999 11.732,4.050 11.829,3.925 C12.020,3.678 12.020,3.320 11.829,3.074 ZM7.370,1.771 C7.569,1.651 7.846,1.788 7.989,2.077 C8.132,2.366 8.087,2.696 7.888,2.816 C7.689,2.936 7.412,2.799 7.269,2.510 C7.126,2.221 7.171,1.890 7.370,1.771 ZM6.468,5.930 C4.404,5.930 2.668,4.183 2.067,3.499 C2.473,3.037 3.397,2.091 4.589,1.525 C4.357,1.915 4.220,2.381 4.220,2.883 C4.220,4.251 5.227,5.360 6.468,5.360 C7.709,5.360 8.715,4.251 8.715,2.883 C8.715,2.381 8.579,1.915 8.346,1.525 C9.539,2.091 10.463,3.037 10.869,3.499 C10.268,4.184 8.531,5.930 6.468,5.930 Z"/>
                                                                                </svg> <?= ' ' . (Post::find($post->id))->view ?></span>
                                                            </li>
                                                            <li><span class="blog_bg_pink"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="13px"
                                                                            height="10px">
                                                                                    <path fill-rule="evenodd"
                                                                                          fill="rgb(255, 255, 255)"
                                                                                          d="M12.485,7.049 C12.142,7.544 11.670,7.962 11.070,8.303 C11.119,8.417 11.168,8.520 11.219,8.615 C11.270,8.710 11.330,8.801 11.401,8.889 C11.471,8.977 11.525,9.045 11.564,9.095 C11.603,9.145 11.665,9.214 11.752,9.305 C11.840,9.394 11.895,9.453 11.919,9.482 C11.924,9.487 11.934,9.497 11.948,9.514 C11.963,9.530 11.974,9.542 11.981,9.549 C11.988,9.556 11.998,9.568 12.010,9.585 C12.022,9.602 12.030,9.614 12.035,9.624 L12.053,9.659 C12.053,9.659 12.058,9.673 12.068,9.702 C12.077,9.730 12.078,9.745 12.071,9.748 C12.064,9.750 12.062,9.766 12.064,9.794 C12.050,9.860 12.018,9.912 11.970,9.950 C11.921,9.988 11.868,10.005 11.810,10.000 C11.568,9.967 11.360,9.929 11.186,9.887 C10.441,9.697 9.769,9.394 9.169,8.977 C8.734,9.053 8.309,9.091 7.893,9.091 C6.582,9.091 5.441,8.778 4.469,8.153 C4.749,8.172 4.962,8.182 5.107,8.182 C5.886,8.182 6.633,8.075 7.349,7.862 C8.064,7.649 8.703,7.343 9.264,6.946 C9.868,6.510 10.333,6.008 10.657,5.440 C10.981,4.872 11.143,4.271 11.143,3.637 C11.143,3.272 11.087,2.912 10.976,2.557 C11.600,2.893 12.093,3.315 12.456,3.821 C12.818,4.328 13.000,4.872 13.000,5.455 C13.000,6.023 12.828,6.554 12.485,7.049 ZM7.672,6.787 C6.886,7.111 6.031,7.273 5.107,7.272 C4.691,7.272 4.266,7.235 3.830,7.159 C3.231,7.575 2.558,7.879 1.814,8.068 C1.640,8.111 1.432,8.148 1.190,8.182 L1.168,8.182 C1.115,8.182 1.065,8.163 1.019,8.125 C0.973,8.087 0.946,8.037 0.936,7.976 C0.931,7.962 0.929,7.946 0.929,7.930 C0.929,7.914 0.930,7.898 0.932,7.884 C0.935,7.869 0.939,7.855 0.947,7.841 L0.965,7.805 C0.965,7.805 0.973,7.792 0.990,7.767 C1.007,7.740 1.017,7.729 1.019,7.731 C1.022,7.734 1.033,7.722 1.052,7.696 C1.071,7.670 1.081,7.659 1.081,7.664 C1.105,7.636 1.161,7.577 1.248,7.486 C1.335,7.396 1.398,7.326 1.436,7.277 C1.475,7.227 1.530,7.158 1.600,7.071 C1.670,6.983 1.730,6.892 1.781,6.797 C1.832,6.703 1.881,6.598 1.930,6.485 C1.330,6.144 0.859,5.725 0.515,5.228 C0.172,4.731 0.000,4.200 0.000,3.637 C0.000,2.978 0.227,2.370 0.682,1.812 C1.137,1.253 1.757,0.812 2.543,0.487 C3.329,0.163 4.183,0.000 5.107,0.000 C6.031,0.000 6.886,0.162 7.672,0.487 C8.458,0.812 9.078,1.253 9.532,1.812 C9.987,2.370 10.214,2.978 10.214,3.637 C10.214,4.295 9.987,4.903 9.532,5.462 C9.078,6.020 8.458,6.462 7.672,6.787 ZM8.716,2.280 C8.337,1.859 7.825,1.525 7.182,1.279 C6.539,1.033 5.847,0.910 5.107,0.910 C4.367,0.910 3.676,1.033 3.032,1.279 C2.389,1.525 1.878,1.859 1.498,2.280 C1.119,2.702 0.929,3.154 0.929,3.637 C0.929,4.025 1.057,4.399 1.313,4.759 C1.569,5.119 1.930,5.431 2.394,5.697 L3.098,6.094 L2.844,6.691 C3.008,6.596 3.158,6.503 3.294,6.414 L3.613,6.194 L3.997,6.264 C4.375,6.331 4.745,6.364 5.107,6.364 C5.847,6.364 6.539,6.240 7.182,5.994 C7.825,5.748 8.337,5.415 8.716,4.993 C9.096,4.572 9.286,4.120 9.286,3.637 C9.286,3.154 9.096,2.702 8.716,2.280 Z"/>
                                                                                </svg><?= ' ' . Comment::where('post_id', $post->id)->count() ?></span>
                                                            </li>
                                                        </ul>
                                                        <div class="blog_author_data">
                                                            <a href="single.php?id=<?= $post->id ?>">
                                                                <?= User::find($post->user_id)->name ?>
                                                                <img src="uploads/avatars/<?= User::find($post->user_id)->avatar ?>" class="img-fluid" alt="" width="34" height="34">
                                                            </a>
                                                        </div>

                                                        <p style="margin-top: 10px"><?= mb_substr($post->des, 0, 160) . '...' ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <div style="height: 70vh; width: 100vw">
                                            <div style="width: 100%;text-align:center;position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid #f5c6cb;border-radius:.25rem;color:#721c24;background-color:#f8d7da;">
                                                <span style="color: red; font-size: 24px">مقاله ای یافت نشد!</span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="blog_main_wrapper ">

</div>
<?php include_once 'footer.php' ?>