<!--header area start-->
<?php
//views/homes/index.php
require_once 'helpers/Helper.php';
?>
<!--Offcanvas menu area start-->
<div class="off_canvars_overlay">

</div>
<div class="Offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                    <div class="header_support">
                        <p><i class="icon ion-android-alarm-clock"></i> Ordered before 17:30, shipped today - Support: <a href="tel:+0123456789">0123456789</a></p>
                    </div>
                    <div class="header_account top">
                        <ul>
                            <li class="language"><a href="#">Language : ENG  <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_language">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Germany</a></li>
                                    <li><a href="#">Japanese</a></li>
                                </ul>
                            </li>
                            <li class="currency"><a href="#">Currency : USD <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_currency">
                                    <li><a href="#">EUR – Euro</a></li>
                                    <li><a href="#">GBP – British Pound</a></li>
                                    <li><a href="#">INR – India Rupee</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="header_account bottom">
                        <ul>
                            <li class="wishlist"><a href="wishlist.html"><i class="icon ion-clipboard"></i> Wishlist </a></li>
                            <li class="top_links"><a href="#"><i class="ion-gear-a"></i> Setting <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_links">
                                    <li><a href="checkout.html">Checkout </a></li>
                                    <li><a href="my-account.html">My Account </a></li>
                                    <li><a href="cart.html">Shopping Cart</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="search_container">
                        <form action="" method="get">
                            <div class="hover_category">
                                <?php if(!empty($categories)): ?>
                                <select class="select_option" name="select" id="categori1">
                                    <?php foreach ($categories as $category): ?>
                                    <option selected value="<?php echo $category['id']?>"><?php echo $category['name']?></option>
<!--                                    <option value="2">Accessories</option>-->
<!--                                    <option value="3">Accessories & More</option>-->
<!--                                    <option value="4">Butters & Eggs</option>-->
<!--                                    <option value="5">Camera & Video </option>-->
<!--                                    <option value="6">Mornitors</option>-->
<!--                                    <option value="7">Tablets</option>-->
<!--                                    <option value="8">Laptops</option>-->
<!--                                    <option value="9">Handbags</option>-->
<!--                                    <option value="10">Headphone & Speaker</option>-->
<!--                                    <option value="11">Herbs & botanicals</option>-->
<!--                                    <option value="12">Vegetables</option>-->
<!--                                    <option value="13">Shop</option>-->
<!--                                    <option value="14">Laptops & Desktops</option>-->
<!--                                    <option value="15">Watchs</option>-->
<!--                                    <option value="16">Electronic</option>-->
                                    <?php endforeach; ?>
                                </select>
                                <?php endif; ?>
                            </div>
                            <div class="search_box">
                                <input placeholder="Search product..." type="text" name="search"
                                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                <button type="submit">Search</button>
                                <!--
                       frontend/views/layouts/header.php, search từ Tìm kiềm sản phẩm
                       Khi phương thức của form là GET, bắt buộc phải thêm 2 input ẩn với type=hidden,
                        để giữ lại giá trị của 2 tham số controller và action sau khi submit form,
                        theo như cách sau:
                        -->
                                <input type="hidden" name="controller" value="product" />
                                <input type="hidden" name="action" value="search" />
                            </div>
                        </form>
                    </div>
                    <div class="mini_cart_wrapper">
                        <a href="javascript:void(0)">
                               <span class="cart_icon">
                                   <i class="ion-android-cart"></i>
                               </span>
                            <?php
                            // Khai báo tổng giá trị đơn hàng
                            $total_cart = 0;
                            // tổng số lượng
                            $cart_total = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] AS $cart) {
                                    $cart_total += $cart['quantity']; // cộng tất cả quantity của cart lại
                                }
                            }
                            ?>
                            <span class="cart_title">
                                    <span class="cart_quantity"><?php echo $cart_total; ?></span>
                                    <span class="cart_price"><?php echo $total_cart; ?></span>
                                </span>
                        </a>

                        <!--mini cart-->
                        <div class="mini_cart">
                            <?php

                            foreach ($_SESSION['cart'] AS $product_id => $cart): ?>
                            <div class="mini_cart_inner">
                                <div class="cart_item">
                                    <div class="cart_img">
                                        <a href="#"><img src="../backend/assets/uploads/<?php echo $cart['avatar'] ?>" alt=""></a>
                                    </div>
                                    <div class="cart_info">
                                        <a href="chi-tiet-san-pham/<?php echo $product_id?>"><?php echo $cart['name']; ?></a>
                                        <p>Qty: <?php echo $cart['quantity']; ?> X <span> <?php echo number_format($cart['price']) ?> VNĐ </span></p>
                                    </div>
                                    <div class="cart_remove">
                                        <a href="#"><i class="ion-android-close"></i></a>
                                    </div>
                                </div>
                                <div class="mini_cart_table">
                                    <div class="cart_total">
                                        <span>Sub total:</span>
                                        <span class="price">
                                             <?php
                                             $total_item = $cart['price'] * $cart['quantity'];
                                             // Cộng dồn để lấy ra tổng giá trị đơn hàng
                                             $total_cart += $total_item;
                                             echo number_format($total_cart);
                                             ?>
                                        </span>
                                    </div>
                                    <div class="cart_total mt-10">
                                        <span>total:</span>
                                        <span class="price">
                                             <?php
                                             $total_item = $cart['price'] * $cart['quantity'];
                                             // Cộng dồn để lấy ra tổng giá trị đơn hàng
                                             $total_cart += $total_item;
                                             echo number_format($total_cart);
                                             ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="mini_cart_footer">
                                <div class="cart_button">
                                    <a href="cart.html">View cart</a>
                                </div>
                                <div class="cart_button">
                                    <a href="checkout.html">Checkout</a>
                                </div>

                            </div>

                        </div>
                        <!--mini cart end-->
                    </div>
                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children active">
                                <a href="#">Home</a>
                                <ul class="sub-menu">
                                    <li><a href="index.html">Home 1</a></li>
                                    <li><a href="index-2.html">Home 2</a></li>
                                    <li><a href="index-3.html">Home 3</a></li>
                                    <li><a href="index-4.html">Home 4</a></li>
                                    <li><a href="index-5.html">Home 5</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Shop</a>
                                <ul class="sub-menu">
                                    <li class="menu-item-has-children">
                                        <a href="#">Shop Layouts</a>
                                        <ul class="sub-menu">
                                            <li><a href="shop.html">shop</a></li>
                                            <li><a href="shop-fullwidth.html">Full Width</a></li>
                                            <li><a href="shop-fullwidth-list.html">Full Width list</a></li>
                                            <li><a href="shop-right-sidebar.html">Right Sidebar </a></li>
                                            <li><a href="shop-right-sidebar-list.html"> Right Sidebar list</a></li>
                                            <li><a href="shop-list.html">List View</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">blog</a>
                                <ul class="sub-menu">
                                    <li><a href="blog.html">blog</a></li>
                                    <li><a href="blog-details.html">blog details</a></li>
                                    <li><a href="blog-fullwidth.html">blog fullwidth</a></li>
                                    <li><a href="blog-sidebar.html">blog sidebar</a></li>
                                    <li><a href="blog-no-sidebar.html">blog no sidebar</a></li>
                                </ul>

                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">pages </a>
                                <ul class="sub-menu">
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="services.html">services</a></li>
                                    <li><a href="faq.html">Frequently Questions</a></li>
                                    <li><a href="contact.html">contact</a></li>
                                    <li><a href="login.html">login</a></li>
                                    <li><a href="404.html">Error 404</a></li>
                                    <li><a href="compare.html">compare</a></li>
                                    <li><a href="coming-soon.html">coming soon</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="my-account.html">my account</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="portfolio.html">portfolio</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="contact.html"> Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="Offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Offcanvas menu area end-->

<header>
    <div class="main_header common_header">
        <!--header top start-->
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4">
                        <div class="header_account">
                            <ul>
                                <li class="language"><a href="#">Language : ENG  <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_language">
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Germany</a></li>
                                        <li><a href="#">Japanese</a></li>
                                    </ul>
                                </li>
                                <li class="currency"><a href="#">Currency : USD <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_currency">
                                        <li><a href="#">EUR – Euro</a></li>
                                        <li><a href="#">GBP – British Pound</a></li>
                                        <li><a href="#">INR – India Rupee</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-9">
                        <div class="top_right text-right">
                            <div class="header_support">
                                <p><i class="icon ion-android-alarm-clock"></i> Ordered before 17:30, shipped today - Support: <a href="tel:+0123456789">0123456789</a></p>
                            </div>
                            <div class="header_account">
                                <ul>
                                    <li class="wishlist"><a href="wishlist.html"><i class="icon ion-clipboard"></i> Wishlist </a></li>
                                    <li class="top_links"><a href="#"><i class="ion-gear-a"></i> Setting <i class="ion-chevron-down"></i></a>
                                        <ul class="dropdown_links">
                                            <li><a href="checkout.html">Checkout </a></li>
                                            <li><a href="my-account.html">My Account </a></li>
                                            <li><a href="cart.html">Shopping Cart</a></li>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header top start-->
        <!--header middel start-->
        <div class="header_middle sticky-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="logo">
                            <a href="#"><img src="assets/img/logo/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="main_menu menu_position text-right">
                            <nav>
                                <ul>
                                    <li><a  href="index.php">home<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu">
                                            <?php if(!empty($categories)): ?>
                                            <?php foreach ($categories as $category) : ?>
                                            <li><a href="index.php?controller=home&action=filterProduct&filter=<?php echo $category['id'] ?>">
                                                    <?php echo $category['name'] ?>
                                                </a>
                                            </li>
<!--                                            <li><a href="index-2.html">Home shop 2</a></li>-->

                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                    <li class="mega_items"><a class="active" href="shop.html">shop<i class="fa fa-angle-down"></i></a>
                                        <div class="mega_menu">
                                            <ul class="mega_menu_inner">
                                                <?php if(!empty($categories)): ?>
                                                <?php foreach ($categories as $category) : ?>
                                                <li><a href="#"><?php echo $category['name'] ?></a>
                                                    <ul>
                                                        <li><a href="shop-fullwidth.html">Full Width</a></li>
                                                        <li><a href="shop-fullwidth-list.html">Full Width list</a></li>
                                                        <li><a href="shop-right-sidebar.html">Right Sidebar </a></li>
                                                        <li><a href="shop-right-sidebar-list.html"> Right Sidebar list</a></li>
                                                        <li><a href="shop-list.html">List View</a></li>
                                                    </ul>
                                                </li>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="blog.html">blog<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="blog-details.html">blog details</a></li>
                                            <li><a href="blog-fullwidth.html">blog fullwidth</a></li>
                                            <li><a href="blog-sidebar.html">blog sidebar</a></li>
                                            <li><a href="blog-no-sidebar.html">blog no sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">pages <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="about.html">About Us</a></li>
                                            <li><a href="services.html">services</a></li>
                                            <li><a href="faq.html">Frequently Questions</a></li>
                                            <li><a href="contact.html">contact</a></li>
                                            <li><a href="login.html">login</a></li>
                                            <li><a href="404.html">Error 404</a></li>
                                            <li><a href="compare.html">compare</a></li>
                                            <li><a href="coming-soon.html">coming soon</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="portfolio.html">portfolio</a></li>
                                    <li><a href="contact.html"> Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--header middel end-->
        <!--header bottom satrt-->
        <div class="header_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-12">
                        <div class="categories_menu">
                            <div class="categories_title">
                                <h2 class="categori_toggle">ALL CATEGORIES</h2>
                            </div>
                            <div class="categories_menu_toggle">
                                <ul>
                                    <li class="menu_item_children"><a href="#">Brake Parts <i class="fa fa-angle-right"></i></a>
                                        <ul class="categories_mega_menu">
                                            <li class="menu_item_children"><a href="#">Dresses</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Sweater</a></li>
                                                    <li><a href="#">Evening</a></li>
                                                    <li><a href="#">Day</a></li>
                                                    <li><a href="#">Sports</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Handbags</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Shoulder</a></li>
                                                    <li><a href="#">Satchels</a></li>
                                                    <li><a href="#">kids</a></li>
                                                    <li><a href="#">coats</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">shoes</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Ankle Boots</a></li>
                                                    <li><a href="#">Clog sandals </a></li>
                                                    <li><a href="#">run</a></li>
                                                    <li><a href="#">Books</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Clothing</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Coats  Jackets </a></li>
                                                    <li><a href="#">Raincoats</a></li>
                                                    <li><a href="#">Jackets</a></li>
                                                    <li><a href="#">T-shirts</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu_item_children"><a href="#"> Wheels & Tires  <i class="fa fa-angle-right"></i></a>
                                        <ul class="categories_mega_menu column_3">
                                            <li class="menu_item_children"><a href="#">Chair</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Dining room</a></li>
                                                    <li><a href="#">bedroom</a></li>
                                                    <li><a href="#"> Home & Office</a></li>
                                                    <li><a href="#">living room</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Lighting</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Ceiling Lighting</a></li>
                                                    <li><a href="#">Wall Lighting</a></li>
                                                    <li><a href="#">Outdoor Lighting</a></li>
                                                    <li><a href="#">Smart Lighting</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Sofa</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Fabric Sofas</a></li>
                                                    <li><a href="#">Leather Sofas</a></li>
                                                    <li><a href="#">Corner Sofas</a></li>
                                                    <li><a href="#">Sofa Beds</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu_item_children"><a href="#"> Furnitured & Decor <i class="fa fa-angle-right"></i></a>
                                        <ul class="categories_mega_menu column_2">
                                            <li class="menu_item_children"><a href="#">Brake Tools</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Driveshafts</a></li>
                                                    <li><a href="#">Spools</a></li>
                                                    <li><a href="#">Diesel </a></li>
                                                    <li><a href="#">Gasoline</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Emergency Brake</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Dolls for Girls</a></li>
                                                    <li><a href="#">Girls' Learning Toys</a></li>
                                                    <li><a href="#">Arts and Crafts for Girls</a></li>
                                                    <li><a href="#">Video Games for Girls</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu_item_children"><a href="#"> Turbo System <i class="fa fa-angle-right"></i></a>
                                        <ul class="categories_mega_menu column_2">
                                            <li class="menu_item_children"><a href="#">Check Trousers</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Building</a></li>
                                                    <li><a href="#">Electronics</a></li>
                                                    <li><a href="#">action figures </a></li>
                                                    <li><a href="#">specialty & boutique toy</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu_item_children"><a href="#">Calculators</a>
                                                <ul class="categorie_sub_menu">
                                                    <li><a href="#">Dolls for Girls</a></li>
                                                    <li><a href="#">Girls' Learning Toys</a></li>
                                                    <li><a href="#">Arts and Crafts for Girls</a></li>
                                                    <li><a href="#">Video Games for Girls</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="#"> Lighting</a></li>
                                    <li><a href="#"> Accessories</a></li>
                                    <li><a href="#">Body Parts</a></li>
                                    <li><a href="#">Perfomance Filters</a></li>
                                    <li><a href="#"> Engine Parts</a></li>
                                    <li id="cat_toggle" class="has-sub"><a href="#"> More Categories</a>
                                        <ul class="categorie_sub">
                                            <li><a href="#">Hide Categories</a></li>
                                        </ul>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-6">
                        <div class="bottom_right">
                            <div class="search_container">
                                <form action="" method="GET">
<!--                                    --><?php //if(!empty($categories)): ?>
<!--                                    <div class="hover_category">-->
<!--                                        <select class="select_option" name="category_id" id="categori2">-->
<!--                                            --><?php //foreach ($categories as $category):
//                                            //giữ trạng thái selected của category sau khi chọn dựa vào
//                                            //                tham số category_id trên trình duyệt
//                                            $selected = '';
//                                            if (isset($_GET['category_id']) && $category['id'] == $_GET['category_id']) {
//                                                $selected = 'selected';
//                                            }
//                                            ?>
<!--                                            <option value="--><?php //echo $category['id'] ?><!--"  --><?php //echo $selected; ?><!-->
<!--                                                --><?php //echo $category['name'] ?>
<!--                                            </option>-->
<!--                                            --><?php //endforeach; ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                    --><?php //endif; ?>
                                    <div class="search_box">
                                        <input placeholder="Search product..." type="text" name="name" name="search"
                                               value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>" />
                                        <button type="submit">Search</button>
                                        <!--
                                           frontend/views/layouts/header.php, search từ Tìm kiềm sản phẩm
                                           Khi phương thức của form là GET, bắt buộc phải thêm 2 input ẩn với type=hidden,
                                            để giữ lại giá trị của 2 tham số controller và action sau khi submit form,
                                            theo như cách sau:
                                            -->
                                        <input type="hidden" name="controller" value="home" />
                                        <input type="hidden" name="action" value="search" />
                                    </div>
                                </form>
                            </div>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)">
                                       <span class="cart_icon">
                                           <i class="ion-android-cart"></i>
                                       </span>

                                    <span class="cart_title">
                                            <span class="cart_quantity"><?php echo $cart_total; ?></span>
<!--                                            <span class="cart_price">$152.00</span>-->
                                        </span>
                                </a>

                                <!--mini cart-->
                                <div class="mini_cart">


                                    <div class="mini_cart_inner">
                                        <?php
                                        // Khai báo tổng giá trị đơn hàng
                                        $total_cart = 0;
                                        if(!empty($_SESSION['cart'])):
                                        foreach ($_SESSION['cart'] AS $product_id => $cart):
                                        $slug = Helper::getSlug($cart['name']);
                                        $product_link = "san-pham/$slug/" . $product_id . ".html";
                                        ?>
                                        <div class="cart_item">
                                            <div class="cart_img">
                                                <a href="<?php echo $product_link; ?>"><img src="../backend/assets/uploads/<?php echo $cart['avatar'] ?>" alt=""></a>
                                            </div>
                                            <div class="cart_info">
                                                <a href="<?php echo $product_link; ?>"> <?php echo $cart['name']; ?></a>
                                                <p>Qty: <?php echo $cart['quantity']; ?> X <span> <?php echo number_format($cart['price']) ?> VNĐ </span></p>
                                            </div>
                                            <div class="cart_remove">
                                                <a href="xoa-san-pham-mini-cart/<?php echo $product_id; ?>.html"><i class="ion-android-close"></i></a>
                                            </div>
                                        </div>
                                            <?php
                                            $total_item = $cart['price'] * $cart['quantity'];
                                            // Cộng dồn để lấy ra tổng giá trị đơn hàng
                                            $total_cart += $total_item;
//                                            echo number_format($total_item);
                                            ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <div class="mini_cart_table">
<!--                                            <div class="cart_total">-->
<!--                                                <span>Sub total:</span>-->
<!--                                                <span class="price">-->
<!--                                                    --><?php
//                                                    echo number_format($total_item);
//                                                    ?><!-- VNĐ-->
<!--                                                </span>-->
<!--                                            </div>-->

                                            <div class="cart_total mt-10">
                                                <span>Sub total:</span>
                                                <span class="price">
                                                    <?php
                                                    echo number_format($total_cart);
                                                    ?> VNĐ
                                                </span>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="gio-hang-cua-ban.html">View cart</a>
                                        </div>
                                        <div class="cart_button">
                                            <a href="checkout.html">Checkout</a>
                                        </div>

                                    </div>

                                </div>
                                <!--mini cart end-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="ajax-message"></span>
        <!--header bottom end-->
    </div>
</header>
<!--header area end-->

<!--shop banner area start-->
<div class="shop_banner_area mt-50 mb-45">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop_banner_thumb">
                    <img src="assets/img/bg/banner16.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!--shop banner area end-->


<?php
//echo "<pre>";
//print_r($categories);
//echo "</pre>";
//?>