<div class="blog_main_header" style="position: fixed;top: 0;right: 0;left: 0;z-index: 1030;">
    <div class="blog_logo">
        <a href="/"><img src="assets/images/logo.png" class="img-fluid" alt="logo"></a>
        <div class="blog_menu_toggle">
                    <span>
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </span>
        </div>
    </div>
    <div class="blog_main_menu">
        <div class="blog_main_menu_innerdiv">
            <ul>
                <li class="active"><a href="/">خانه</a>
                </li>
                <?php use Wlog\Model\Category;

                $categories = Category::all();
                foreach ($categories as $category):
                    if ($category->subcat_id == 0):?>
                        <li><a href="cat.php?id=<?= $category->id ?>"><?= $category->name; ?></a>
                            <?php $sub_categories = Category::where('subcat_id', $category->id)->get();
                            if ($sub_categories->count() > 0):?>
                                <ul class="sub-menu">
                                    <?php foreach ($sub_categories as $sub_category): ?>
                                        <li><a href="cat.php?id=<?= $sub_category->id ?>"><?= $sub_category->name ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div style="margin-left: 20px">
        <?php if (isset($_SESSION['user_id'])): ?>
        <a class="btn btn-primary" style="color: white" href="auth.php">داشبورد</a>
        <?php else: ?>
        <a class="btn btn-primary" style="color: white" href="auth.php">ورود</a>
        <?php endif; ?>
    </div>
    <div class="blog_top_search">
        <form method="get" action="search.php" class="form-inline" style="display: inline">
            <div class="blog_form_group" style="display: flex;">
                <input name="word" type="text" class="form-control" placeholder="جستجو کنید">
                <button name="search" type="submit" style="cursor: pointer; margin-right: 5px" class="blog_header_search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px">
                        <path fill-rule="evenodd" fill="rgb(255, 54, 87)" d="M15.750,14.573 L11.807,10.612 C12.821,9.449 13.376,7.984 13.376,6.459 C13.376,2.898 10.376,-0.000 6.687,-0.000 C2.999,-0.000 -0.002,2.898 -0.002,6.459 C-0.002,10.021 2.999,12.919 6.687,12.919 C8.072,12.919 9.391,12.516 10.520,11.750 L14.493,15.741 C14.659,15.907 14.882,15.999 15.121,15.999 C15.348,15.999 15.563,15.916 15.726,15.764 C16.073,15.442 16.084,14.908 15.750,14.573 ZM6.687,1.685 C9.414,1.685 11.631,3.827 11.631,6.459 C11.631,9.092 9.414,11.234 6.687,11.234 C3.961,11.234 1.743,9.092 1.743,6.459 C1.743,3.827 3.961,1.685 6.687,1.685 Z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>