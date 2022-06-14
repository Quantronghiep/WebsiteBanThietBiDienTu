<?php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/OrderDetail.php';
require_once 'libraries/PHPMailer/src/PHPMailer.php';
require_once 'libraries/PHPMailer/src/SMTP.php';
require_once 'libraries/PHPMailer/src/Exception.php';
//Buổi 37
class PaymentController extends Controller
{
    public function index(){
        //Logic xử lí thanh toán : lưu vào 2 bảng theo thứ tự sau :
        // + Bảng orders
        // + Bảng order_details
        // Demo tích hợp thanh toán trực tiếp của 1 bên thứ 3 là nGÂN lượng
        // Chạy file sau : frontend/libraries/nganluong/index.php

        // Xử lí submit form
        // +Debug
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";
        if(isset($_POST['submit'])){
            $fullname = $_POST['fullname'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $note = $_POST['note'];
            //method là phương thức thanh toán : nếu trực tuyến = 0 , COD =1
            $method = $_POST['method'];

            // Validate form : bỏ qua
            if(empty($fullname)){
                $this->error = 'Cần nhập tên';
            }
            elseif (empty($address)){
                $this->error = 'Cần nhập địa chỉ';
            }
            elseif (empty($mobile)){
                $this->error = 'Cần nhập số điện thoại';
            }
            elseif (empty($email)){
                $this->error = 'Cần nhập email';
            }
            else if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error = 'Email không đúng định dạng';
            }
            // + Xử lí logic thanh toán chỉ khi không có lỗi xảy ra
            if(empty($this->error)){
                //Lưu vào bảng orders trước :
                $oder_model = new Order();
                //Gán giá trị từ form cho thuộc tính Model
                $oder_model->fullname = $fullname;
                $oder_model->address = $address;
                $oder_model->mobile = $mobile;
                $oder_model->email = $email;
                $oder_model->note = $note;

                //price_total : tổng giá trị đơn hàng , chưa có sẵn mà cần tính toán ra
                // dựa vào mảng giỏ hàng
                $price_total = 0;
                foreach ($_SESSION['cart'] AS $product_id => $cart){
                    //Thành tiền của từng item
                    $total_item = $cart['quantity'] * $cart['price'];
                    //Cộng dồn vào tổng ban đầu
                    $price_total += $total_item;
                }
                $oder_model->price_total = $price_total;

                // payment_status : trạng thái thanh toán : 0- chưa thanh toán , 1 -đã thanh toán
                $oder_model->payment_status = 0;
                // Chú ý với chức năng và cấu trúc bảng hiện tại , cần trả về  id order vừa insert ,
                //thay vì trả về true/false
                $oder_id = $oder_model->insert(); // lấy id
                var_dump($oder_id);
                // Lưu tiếp vào bảng order_details : chứa thông tin về đơn hàng : sp tên gì , giá = bn ,  số lượng đặt = ?
                foreach ($_SESSION['cart'] AS $product_id =>$cart){
                    $oder_detail_model = new OrderDetail();
                    $oder_detail_model->order_id = $oder_id;
                    $oder_detail_model->product_id = $product_id;
                    $oder_detail_model->product_name = $cart['name'];
                    $oder_detail_model->product_price = $cart['price'];
                    $oder_detail_model->quantity = $cart['quantity'];
                    $is_insert = $oder_detail_model->insert();
//                    var_dump($is_insert);
//                    echo "<pre>";
//                    print_r($_POST);
//                    print_r($_SESSION['cart']);
//                    echo "</pre>";
                }
                //Sau khi lưu thành công vào bảng orders và order_details , cần xử lí chuyển hướng user đến trang
                //tương ứng dựa vào phuwong thức thanh toán mà họ chọn
                //Nếu user chọn thanh toán trực tuyến , thì chuyển hướng sang trang Ngân lượng , tạo session chứa thông tin cần
                //Thiết sang trang ngân lượng
                if($method==0){
                    $_SESSION['info'] =[
                        'price_total' =>$price_total,
                        'fullname' => $fullname,
                        'email' => $email,
                        'mobile' =>$mobile
                    ];
//                    unset($_SESSION['cart']);
                    header("Location: index.php?controller=payment&action=online");
                    exit();

                }
                //Nếu thanh toán COD thì gửi mail cảm ơn , chuyển hướng về trag cảm ơn
                else {
                    unset($_SESSION['cart']);
                    //gửi mail
                    header("Location: index.php?controller=payment&action=thanks");
                    exit();

                }
            }
        }
        $this->content = $this->render('views/payments/index.php');
        $this->page_title = "Thanh toán";
        require_once 'views/layouts/main.php';
    }

    public function online(){
        //Gọi ra view của trang Ngân lượng , do trang Ngân luwojng dùng view riêng , nên ko gọi layout của hệ thống
        // mà hiển thị ra luôn
        $this->content = $this->render('libraries/nganluong/index.php');
        echo $this->content;
    }

    public function thanks(){
        $this->content = $this->render('views/payments/thank.php');
        echo $this->content;    
    }
}