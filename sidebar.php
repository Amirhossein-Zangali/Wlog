<?php
require_once __DIR__ . '/init.php';

use Wlog\Model\Category;
use Wlog\Model\Comment;
use Wlog\Model\Post;
use Wlog\Model\User;
?>
<div class="col-lg-3 col-md-12 col-sm-12 col-12 theiaStickySidebar">
    <div class="blog_sidebar">
        <div class="widget widget_categories wow fadeInUp"
             style="visibility: visible; animation-name: fadeInUp;">
            <div class="blog_main_heading_div">
                <div class="blog_heading_div">
                    <h3 class="blog_bg_lightgreen">دسته بندی ها</h3>
                </div>
            </div>
            <ul class="category-list">
                <?php $categories = Category::all();
                foreach ($categories as $category):
                    if ($category->subcat_id == 0):
                        $sub_categories = Category::where('subcat_id', $category->id)->get();
                        ?>
                        <li class="<?= $sub_categories->count() > 0 ? 'has-children' : '' ?>">
                            <a style="display: inline;" href="cat.php?id=<?= $category->id ?>" class="category-toggle"><?= $category->name; ?></a>
                            <span style="display: inline;float: left;padding-right: 135px" class="icon"></span>
                            <?php if ($sub_categories->count() > 0): ?>
                                <ul class="dropdown">
                                    <?php foreach ($sub_categories as $sub_category): ?>
                                        <li><a href="cat.php?id=<?= $sub_category->id ?>"><?= $sub_category->name ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; endforeach; ?>
            </ul>
        </div>
        <div class="widget widget_special_post wow fadeInUp">
            <div class="blog_main_heading_div">
                <div class="blog_heading_div">
                    <h3 class="blog_bg_pink">اخبار داغ</h3>
                </div>
            </div>
            <ul>
                <?php $posts = Post::orderBy('view', 'desc')->limit(3)->get();
                foreach ($posts as $post): ?>
                    <li>
                        <div class="blog_post_slider_wrapper">
                            <a href="single.php?id=<?= $post->id ?>" class="blog_post_slider_img">
                                <img src="uploads/thumbnails/<?= $post->thumbnail ?>" class="img-fluid"
                                     alt="">
                            </a>
                            <div class="blog_post_slider_content">
                                <h2>
                                    <a href="single.php?id=<?= $post->id ?>"><?= mb_substr(explode(':', $post->title)[0], 0, 100) ?></a>
                                </h2>
                                <ul class="blog_meta_tags">
                                    <li><span class="blog_bg_blue"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="12px"
                                                height="7px">
                                                                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                                                          d="M11.829,3.074 C11.732,2.948 9.422,-0.000 6.468,-0.000 C3.514,-0.000 1.203,2.948 1.106,3.074 C0.916,3.320 0.916,3.678 1.106,3.925 C1.203,4.050 3.514,6.999 6.468,6.999 C9.422,6.999 11.732,4.050 11.829,3.925 C12.020,3.678 12.020,3.320 11.829,3.074 ZM7.370,1.771 C7.569,1.651 7.846,1.788 7.989,2.077 C8.132,2.366 8.087,2.696 7.888,2.816 C7.689,2.936 7.412,2.799 7.269,2.510 C7.126,2.221 7.171,1.890 7.370,1.771 ZM6.468,5.930 C4.404,5.930 2.668,4.183 2.067,3.499 C2.473,3.037 3.397,2.091 4.589,1.525 C4.357,1.915 4.220,2.381 4.220,2.883 C4.220,4.251 5.227,5.360 6.468,5.360 C7.709,5.360 8.715,4.251 8.715,2.883 C8.715,2.381 8.579,1.915 8.346,1.525 C9.539,2.091 10.463,3.037 10.869,3.499 C10.268,4.184 8.531,5.930 6.468,5.930 Z">
                                                                    </path>
                                                                </svg><?= ' ' . (Post::find($post->id))->view ?></span>
                                    </li>
                                    <li><span class="blog_bg_pink"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="13px"
                                                height="10px">
                                                                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                                                          d="M12.485,7.049 C12.142,7.544 11.670,7.962 11.070,8.303 C11.119,8.417 11.168,8.520 11.219,8.615 C11.270,8.710 11.330,8.801 11.401,8.889 C11.471,8.977 11.525,9.045 11.564,9.095 C11.603,9.145 11.665,9.214 11.752,9.305 C11.840,9.394 11.895,9.453 11.919,9.482 C11.924,9.487 11.934,9.497 11.948,9.514 C11.963,9.530 11.974,9.542 11.981,9.549 C11.988,9.556 11.998,9.568 12.010,9.585 C12.022,9.602 12.030,9.614 12.035,9.624 L12.053,9.659 C12.053,9.659 12.058,9.673 12.068,9.702 C12.077,9.730 12.078,9.745 12.071,9.748 C12.064,9.750 12.062,9.766 12.064,9.794 C12.050,9.860 12.018,9.912 11.970,9.950 C11.921,9.988 11.868,10.005 11.810,10.000 C11.568,9.967 11.360,9.929 11.186,9.887 C10.441,9.697 9.769,9.394 9.169,8.977 C8.734,9.053 8.309,9.091 7.893,9.091 C6.582,9.091 5.441,8.778 4.469,8.153 C4.749,8.172 4.962,8.182 5.107,8.182 C5.886,8.182 6.633,8.075 7.349,7.862 C8.064,7.649 8.703,7.343 9.264,6.946 C9.868,6.510 10.333,6.008 10.657,5.440 C10.981,4.872 11.143,4.271 11.143,3.637 C11.143,3.272 11.087,2.912 10.976,2.557 C11.600,2.893 12.093,3.315 12.456,3.821 C12.818,4.328 13.000,4.872 13.000,5.455 C13.000,6.023 12.828,6.554 12.485,7.049 ZM7.672,6.787 C6.886,7.111 6.031,7.273 5.107,7.272 C4.691,7.272 4.266,7.235 3.830,7.159 C3.231,7.575 2.558,7.879 1.814,8.068 C1.640,8.111 1.432,8.148 1.190,8.182 L1.168,8.182 C1.115,8.182 1.065,8.163 1.019,8.125 C0.973,8.087 0.946,8.037 0.936,7.976 C0.931,7.962 0.929,7.946 0.929,7.930 C0.929,7.914 0.930,7.898 0.932,7.884 C0.935,7.869 0.939,7.855 0.947,7.841 L0.965,7.805 C0.965,7.805 0.973,7.792 0.990,7.767 C1.007,7.740 1.017,7.729 1.019,7.731 C1.022,7.734 1.033,7.722 1.052,7.696 C1.071,7.670 1.081,7.659 1.081,7.664 C1.105,7.636 1.161,7.577 1.248,7.486 C1.335,7.396 1.398,7.326 1.436,7.277 C1.475,7.227 1.530,7.158 1.600,7.071 C1.670,6.983 1.730,6.892 1.781,6.797 C1.832,6.703 1.881,6.598 1.930,6.485 C1.330,6.144 0.859,5.725 0.515,5.228 C0.172,4.731 0.000,4.200 0.000,3.637 C0.000,2.978 0.227,2.370 0.682,1.812 C1.137,1.253 1.757,0.812 2.543,0.487 C3.329,0.163 4.183,0.000 5.107,0.000 C6.031,0.000 6.886,0.162 7.672,0.487 C8.458,0.812 9.078,1.253 9.532,1.812 C9.987,2.370 10.214,2.978 10.214,3.637 C10.214,4.295 9.987,4.903 9.532,5.462 C9.078,6.020 8.458,6.462 7.672,6.787 ZM8.716,2.280 C8.337,1.859 7.825,1.525 7.182,1.279 C6.539,1.033 5.847,0.910 5.107,0.910 C4.367,0.910 3.676,1.033 3.032,1.279 C2.389,1.525 1.878,1.859 1.498,2.280 C1.119,2.702 0.929,3.154 0.929,3.637 C0.929,4.025 1.057,4.399 1.313,4.759 C1.569,5.119 1.930,5.431 2.394,5.697 L3.098,6.094 L2.844,6.691 C3.008,6.596 3.158,6.503 3.294,6.414 L3.613,6.194 L3.997,6.264 C4.375,6.331 4.745,6.364 5.107,6.364 C5.847,6.364 6.539,6.240 7.182,5.994 C7.825,5.748 8.337,5.415 8.716,4.993 C9.096,4.572 9.286,4.120 9.286,3.637 C9.286,3.154 9.096,2.702 8.716,2.280 Z">
                                                                    </path>
                                                                </svg><?= ' ' . Comment::where('post_id', $post->id)->count() ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="widget widget_special_post wow fadeInUp">
            <div class="blog_main_heading_div">
                <div class="blog_heading_div">
                    <h3 class="blog_bg_pink">اخبار تازه</h3>
                </div>
            </div>
            <ul>
                <?php $posts = Post::orderBy('id', 'desc')->limit(3)->get();
                foreach ($posts as $post): ?>
                    <li>
                        <div class="blog_post_slider_wrapper">
                            <a href="single.php?id=<?= $post->id ?>" class="blog_post_slider_img">
                                <img src="uploads/thumbnails/<?= $post->thumbnail ?>" class="img-fluid"
                                     alt="">
                            </a>
                            <div class="blog_post_slider_content">
                                <h2>
                                    <a href="single.php?id=<?= $post->id ?>"><?= mb_substr(explode(':', $post->title)[0], 0, 100) ?></a>
                                </h2>
                                <ul class="blog_meta_tags">
                                    <li><span class="blog_bg_blue"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="12px"
                                                height="7px">
                                                                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                                                          d="M11.829,3.074 C11.732,2.948 9.422,-0.000 6.468,-0.000 C3.514,-0.000 1.203,2.948 1.106,3.074 C0.916,3.320 0.916,3.678 1.106,3.925 C1.203,4.050 3.514,6.999 6.468,6.999 C9.422,6.999 11.732,4.050 11.829,3.925 C12.020,3.678 12.020,3.320 11.829,3.074 ZM7.370,1.771 C7.569,1.651 7.846,1.788 7.989,2.077 C8.132,2.366 8.087,2.696 7.888,2.816 C7.689,2.936 7.412,2.799 7.269,2.510 C7.126,2.221 7.171,1.890 7.370,1.771 ZM6.468,5.930 C4.404,5.930 2.668,4.183 2.067,3.499 C2.473,3.037 3.397,2.091 4.589,1.525 C4.357,1.915 4.220,2.381 4.220,2.883 C4.220,4.251 5.227,5.360 6.468,5.360 C7.709,5.360 8.715,4.251 8.715,2.883 C8.715,2.381 8.579,1.915 8.346,1.525 C9.539,2.091 10.463,3.037 10.869,3.499 C10.268,4.184 8.531,5.930 6.468,5.930 Z">
                                                                    </path>
                                                                </svg><?= ' ' . (Post::find($post->id))->view ?></span>
                                    </li>
                                    <li><span class="blog_bg_pink"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="13px"
                                                height="10px">
                                                                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                                                          d="M12.485,7.049 C12.142,7.544 11.670,7.962 11.070,8.303 C11.119,8.417 11.168,8.520 11.219,8.615 C11.270,8.710 11.330,8.801 11.401,8.889 C11.471,8.977 11.525,9.045 11.564,9.095 C11.603,9.145 11.665,9.214 11.752,9.305 C11.840,9.394 11.895,9.453 11.919,9.482 C11.924,9.487 11.934,9.497 11.948,9.514 C11.963,9.530 11.974,9.542 11.981,9.549 C11.988,9.556 11.998,9.568 12.010,9.585 C12.022,9.602 12.030,9.614 12.035,9.624 L12.053,9.659 C12.053,9.659 12.058,9.673 12.068,9.702 C12.077,9.730 12.078,9.745 12.071,9.748 C12.064,9.750 12.062,9.766 12.064,9.794 C12.050,9.860 12.018,9.912 11.970,9.950 C11.921,9.988 11.868,10.005 11.810,10.000 C11.568,9.967 11.360,9.929 11.186,9.887 C10.441,9.697 9.769,9.394 9.169,8.977 C8.734,9.053 8.309,9.091 7.893,9.091 C6.582,9.091 5.441,8.778 4.469,8.153 C4.749,8.172 4.962,8.182 5.107,8.182 C5.886,8.182 6.633,8.075 7.349,7.862 C8.064,7.649 8.703,7.343 9.264,6.946 C9.868,6.510 10.333,6.008 10.657,5.440 C10.981,4.872 11.143,4.271 11.143,3.637 C11.143,3.272 11.087,2.912 10.976,2.557 C11.600,2.893 12.093,3.315 12.456,3.821 C12.818,4.328 13.000,4.872 13.000,5.455 C13.000,6.023 12.828,6.554 12.485,7.049 ZM7.672,6.787 C6.886,7.111 6.031,7.273 5.107,7.272 C4.691,7.272 4.266,7.235 3.830,7.159 C3.231,7.575 2.558,7.879 1.814,8.068 C1.640,8.111 1.432,8.148 1.190,8.182 L1.168,8.182 C1.115,8.182 1.065,8.163 1.019,8.125 C0.973,8.087 0.946,8.037 0.936,7.976 C0.931,7.962 0.929,7.946 0.929,7.930 C0.929,7.914 0.930,7.898 0.932,7.884 C0.935,7.869 0.939,7.855 0.947,7.841 L0.965,7.805 C0.965,7.805 0.973,7.792 0.990,7.767 C1.007,7.740 1.017,7.729 1.019,7.731 C1.022,7.734 1.033,7.722 1.052,7.696 C1.071,7.670 1.081,7.659 1.081,7.664 C1.105,7.636 1.161,7.577 1.248,7.486 C1.335,7.396 1.398,7.326 1.436,7.277 C1.475,7.227 1.530,7.158 1.600,7.071 C1.670,6.983 1.730,6.892 1.781,6.797 C1.832,6.703 1.881,6.598 1.930,6.485 C1.330,6.144 0.859,5.725 0.515,5.228 C0.172,4.731 0.000,4.200 0.000,3.637 C0.000,2.978 0.227,2.370 0.682,1.812 C1.137,1.253 1.757,0.812 2.543,0.487 C3.329,0.163 4.183,0.000 5.107,0.000 C6.031,0.000 6.886,0.162 7.672,0.487 C8.458,0.812 9.078,1.253 9.532,1.812 C9.987,2.370 10.214,2.978 10.214,3.637 C10.214,4.295 9.987,4.903 9.532,5.462 C9.078,6.020 8.458,6.462 7.672,6.787 ZM8.716,2.280 C8.337,1.859 7.825,1.525 7.182,1.279 C6.539,1.033 5.847,0.910 5.107,0.910 C4.367,0.910 3.676,1.033 3.032,1.279 C2.389,1.525 1.878,1.859 1.498,2.280 C1.119,2.702 0.929,3.154 0.929,3.637 C0.929,4.025 1.057,4.399 1.313,4.759 C1.569,5.119 1.930,5.431 2.394,5.697 L3.098,6.094 L2.844,6.691 C3.008,6.596 3.158,6.503 3.294,6.414 L3.613,6.194 L3.997,6.264 C4.375,6.331 4.745,6.364 5.107,6.364 C5.847,6.364 6.539,6.240 7.182,5.994 C7.825,5.748 8.337,5.415 8.716,4.993 C9.096,4.572 9.286,4.120 9.286,3.637 C9.286,3.154 9.096,2.702 8.716,2.280 Z">
                                                                    </path>
                                                                </svg><?= ' ' . Comment::where('post_id', $post->id)->count() ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="widget widget_newsletter wow fadeInUp">
            <div class="blog_main_heading_div">
                <div class="blog_heading_div">
                    <h3 class="blog_bg_pink">خبرنامه</h3>
                </div>
            </div>
            <div class="blog_newsletter">
                <p style="text-align: right">اخبار را در ایمیل خود دریافت کنید.</p>
                <form action="action.php" method="post" class="form-inline">
                    <div class="blog_form_group">
                        <input required name="email" type="email" class="form-control" placeholder="ایمیل شما ...">
                        <button name="subscribe" type="submit" class="blog_newsletter_btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17px" height="16px">
                                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                      d="M16.914,0.038 C16.838,-0.030 16.731,-0.046 16.639,-0.002 L0.147,7.802 C0.058,7.844 0.001,7.934 0.000,8.034 C-0.001,8.134 0.054,8.225 0.142,8.269 L4.810,10.602 C4.895,10.645 4.997,10.635 5.074,10.577 L9.611,7.123 L6.049,10.855 C5.998,10.908 5.972,10.981 5.978,11.055 L6.333,15.760 C6.340,15.864 6.409,15.953 6.507,15.986 C6.533,15.994 6.560,15.999 6.586,15.999 C6.659,15.999 6.729,15.967 6.778,15.909 L9.256,12.986 L12.318,14.476 C12.384,14.508 12.461,14.509 12.529,14.480 C12.597,14.449 12.648,14.391 12.670,14.320 L16.989,0.310 C17.019,0.212 16.990,0.105 16.914,0.038 Z"/>
                            </svg>
                        </button>
                    </div>
                    <?php if (isset($_GET['subscribe'])):
                        if ($_GET['subscribe'] == 'true'): ?>
                            <p style="color: #1e7e34;margin-top: 10px">شما با موفقیت عضو خبرنامه شدید.</p>
                        <?php elseif ($_GET['subscribe'] == 'exist'): ?>
                            <p style="color: #d39e00;margin-top: 10px">شما قبلا عضو خبرنامه بودید.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
