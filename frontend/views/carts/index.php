
<!--breadcrumbs area start-->
<div class="breadcrumbs_area mt-45">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--shopping cart area start -->
<div class="shopping_cart_area mt-45">
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="product_remove">Delete</th>
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Khai báo tổng giá trị đơn hàng
                                $total_cart = 0;
                                foreach ($_SESSION['cart'] AS $product_id => $cart): ?>
                                <tr>
                                    <td class="product_remove"><a href="xoa-san-pham/<?php echo $product_id; ?>.html"><i class="fa fa-trash-o"></i></a></td>
                                    <td class="product_thumb"><a href="#"><img src="../backend/assets/uploads/<?php echo $cart['avatar'] ?>" alt=""></a></td>
                                    <td class="product_name"><a href="#"><?php echo $cart['name']; ?></a></td>
                                    <td class="product-price"><?php echo number_format($cart['price']) ?> VNĐ</td>
                                    <td class="product_quantity"><label>Quantity</label>
                                        <input min="1"  name="<?php echo $product_id; ?>"
                                               value="<?php echo $cart['quantity']; ?>" type="number">
                                    </td>
                                    <td class="product_total">
                                        <?php
                                        $total_item = $cart['price'] * $cart['quantity'];
                                        // Cộng dồn để lấy ra tổng giá trị đơn hàng
                                        $total_cart += $total_item;
                                        echo number_format($total_item);
                                        ?> VNĐ
                                    </td>


                                </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="cart_submit">
                            <button type="submit" name="submit" value="Cập nhật lại giá">update cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area start-->
            <div class="coupon_area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left">
                            <h3>Coupon</h3>
                            <div class="coupon_inner">
                                <p>Enter your coupon code if you have one.</p>
                                <input placeholder="Coupon code" type="text">
                                <button type="submit">Apply coupon</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right">
                            <h3>Cart Totals</h3>
                            <div class="coupon_inner">
                                <div class="cart_subtotal">
                                    <p>Subtotal</p>
                                    <p class="cart_amount"><?php echo number_format($total_cart)?> VNĐ</p>
                                </div>
<!--                                <div class="cart_subtotal ">-->
<!--                                    <p>Shipping</p>-->
<!--                                    <p class="cart_amount"><span>Flat Rate:</span> --><?php //echo number_format(30000)?><!-- VNĐ</p>-->
<!--                                </div>-->
<!--                                <a href="#">Calculate shipping</a>-->
<!---->
<!--                                <div class="cart_subtotal">-->
<!--                                    <p>Total</p>-->
<!--                                    <p class="cart_amount">--><?php //echo number_format($total_cart + 30000)?><!-- VNĐ</p>-->
<!--                                </div>-->
                                <div class="checkout_btn">
                                    <a href="thanh-toan.html">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area end-->
        </form>
    </div>
</div>
<!--shopping cart area end -->

