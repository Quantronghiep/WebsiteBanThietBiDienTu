<?php
require_once 'helpers/Helper.php';
?>
<div class="container">
    <h2>Thanh toán</h2>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h5 class="center-align">Thông tin khách hàng</h5>
                <div class="form-group">
                    <label>Họ tên khách hàng</label>
                    <input type="text" name="fullname"
                           value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address"
                           value="<?php echo isset($_POST['address']) ? $_POST['address'] : '' ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>SĐT</label>
                    <input type="number" min="0" name="mobile"
                           value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : '' ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" min="0" name="email"
                           value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Ghi chú thêm</label>
                    <textarea name="note" class="form-control"><?php echo isset($_POST['note']) ? $_POST['note'] : '' ?></textarea>
                </div>
                <div class="form-group">
                    <?php
                    $online = '';
                    $ship_cod = '';
                    if (isset($_POST['method'])) {
                        switch ($_POST['method']) {
                            case 0:
                                $online = 'checked';
                                break;
                            case 1:
                                $ship_cod = 'checked';
                                break;
                        }
                    }
                    ?>
                    <label>Chọn phương thức thanh toán</label> <br />
                    <input type="radio" name="method" value="0" <?php echo $online; ?>/> Thanh toán trực tuyến <br />
                    <input type="radio" name="method"  value="1" <?php echo $ship_cod; ?> /> COD (dựa vào địa chỉ của bạn) <br />
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h5 class="center-align">Thông tin đơn hàng của bạn</h5>
              <?php
              //biến lưu tổng giá trị đơn hàng
              $total = 0;
              if (isset($_SESSION['cart'])):
                ?>
                  <table class="table table-bordered">
                      <tbody>
                      <tr>
                          <th width="40%">Tên sản phẩm</th>
                          <th width="12%">Số lượng</th>
                          <th>Giá</th>
                          <th>Thành tiền</th>
                      </tr>
                      <?php foreach ($_SESSION['cart'] AS $product_id => $cart):
                        $product_link = 'san-pham/' . Helper::getSlug($cart['name']) . "/$product_id";
                        ?>
                          <tr>
                              <td>
                                <?php if (!empty($cart['avatar'])): ?>
                                    <img class="product-avatar img-responsive"
                                         src="../backend/assets/uploads/<?php echo $cart['avatar']; ?>" width="60"/>
                                <?php endif; ?>
                                  <div class="content-product">
                                      <a href="<?php echo $product_link; ?>" class="content-product-a">
                                        <?php echo $cart['name']; ?>
                                      </a>
                                  </div>
                              </td>
                              <td>
                              <span class="product-amount">
                                  <?php echo $cart['quantity']; ?>
                              </span>
                              </td>
                              <td>
                              <span class="product-price-payment">
                                 <?php echo number_format($cart['price'], 0, '.', '.') ?> vnđ
                              </span>
                              </td>
                              <td>
                              <span class="product-price-payment">
                                  <?php
                                  $price_total = $cart['price'] * $cart['quantity'];
                                  $total += $price_total;
                                  ?>
                                <?php echo number_format($price_total, 0, '.', '.') ?> vnđ
                              </span>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                      <tr>
                          <td colspan="5" class="product-total">
                              Tổng giá trị đơn hàng:
                              <span class="product-price">
                                <?php echo number_format($total, 0, '.', '.') ?> vnđ
                            </span>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              <?php endif; ?>

            </div>
        </div>
        <input type="submit" name="submit" value="Thanh toán" class="btn btn-primary">
        <a href="gio-hang-cua-ban.html" class="btn btn-secondary">Về trang giỏ hàng</a>
    </form>
</div>