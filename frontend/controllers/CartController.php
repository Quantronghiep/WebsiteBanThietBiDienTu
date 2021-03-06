<?php
//controllers/CartController.php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';

class CartController extends Controller
{
    public function add() {
        echo "các giá trị hiển thị trong phương thức sẽ là kết quả trả về cho ajax";
        echo "<h2 style='color: red'>Thẻ h2</h2>";
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
        $product_id = $_GET['product_id'];
        // Gọi model để lấy sp theo id
        $product_model = new Product();
        $product = $product_model->getById($product_id);
        // Tạo mảng để chứa các thông tin sp sẽ lưu trong giỏ: tên sp, lưu giá sp, avatar, số lượng sp
        $cart = [
            'name' => $product['title'],
            'price' => $product['price'],
            'avatar' => $product['avatar'],
            'quantity' => 1, //mặc định mỗi 1 lần thêm sp vào giỏ sẽ chỉ thêm 1 sp
        ];
        // - Xử lý logic để thêm cart vào session giỏ hàng: key là id của sp, value là mảng $cart,
        // mảng giỏ hàng đặt tên là $_SESSION['cart']
        // + Nếu giỏ hàng chưa từng tồn tại trc đó, thì tạo giỏ hàng, thêm sp đầu tiên vào giỏ
        if (!isset($_SESSION['cart'])) {
//      $_SESSION['cart'] = [
//        $product_id => $cart
//      ];
            $_SESSION['cart'][$product_id] = $cart;
        }
        // ngược lại nếu giỏ hàng đã tồn tại, thì lại check các case sau
        else {
            // Có 2 trường hợp xảy ra: để biết đc sp thêm vào có tồn tại trong mảng giỏ hàng hay chưa, dựa vào
            //key của mảng giỏ hàng => id của sản phẩm => nếu id trùng -> update quantity, ngược lại thêm mới
            // sử dụng hàm array_key_exists để ktra key đã tồn tại trong mảng hay chưa
            $is_key_exist = array_key_exists($product_id, $_SESSION['cart']);
            // + Nếu sp thêm vào giỏ đã tồn tại trong giỏ, cập nhật số lượng của sp đó lên 1: quantity
            if ($is_key_exist) {
                $_SESSION['cart'][$product_id]['quantity']++;
            } else {
                // + NẾu sp thêm vào giỏ chưa tồn tại, thêm sp mới vào giỏ
                $_SESSION['cart'][$product_id] = $cart;
            }
        }
        // Debug giỏ hàng
        echo "<pre>";
        print_r($_SESSION['cart']);
        echo "</pre>";
    }

    public function index(){
        //Xử lí chức năng update giỏ hàng
//        echo "<pre>";
//        print_r($_POST);
//        print_r($_SESSION['cart']);
//        echo "</pre>";
        if(!isset($_SESSION['cart'])){
            $_SESSION['error'] = "Giỏ hàng trống";
            header('Location:index.php');
            exit();
        }
        if(isset($_POST['submit'])){  // ấn nút cập nhật
            foreach ($_POST as $product_id=>$quantity){
                if(is_numeric($quantity) && $quantity <0){
                    $_SESSION['error'] = 'Số lượng phải > 0';
                    header('Location:gio-hang-cua-ban.html');
                    exit();
                }
            }

            //Lặp mảng giỏ hàng ,, set lại số lượng mới cho từng cart
            foreach ($_SESSION['cart'] as $product_id=>$cart){
                // Vì input để min = 0 nên ko cho âm -> Nếu chỉnh = inspect thì vẫn submit đc
                $_SESSION['cart'][$product_id]['quantity'] = $_POST[$product_id];
            }
            $_SESSION['success'] = " Cập nhật giỏ hàng thành công";
        }
        $this->content = $this->render('views/carts/index.php');
        require_once 'views/layouts/main.php';
    }

    public function deleteMiniCart(){
//        echo "<pre>";
//        print_r($_GET);
//        print_r($_SESSION['cart']);
//        echo "</pre>";
        //Xóa sp khỏi giỏ
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
        //Nếu xóa hết sp trong giỏ thì cần xóa bỏ giỏ hàng
        if(empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
        $_SESSION['success'] = "Xóa sp có id = $id khỏi giỏ hàng thành công";
        $url_redirect = $_SERVER['SCRIPT_NAME'];
//      /PHP/Day37_Demo_Website_Part_7_Cart_Payment_Laravel/mvc_project/frontend/index.php/gio-hang-cua-ban.html
        header("Location: $url_redirect");
        exit();

    }

    public function delete(){
        echo "<pre>";
        print_r($_GET);
        print_r($_SESSION['cart']);
        echo "</pre>";
        //Xóa sp khỏi giỏ
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
        //Nếu xóa hết sp trong giỏ thì cần xóa bỏ giỏ hàng
        if(empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
        $_SESSION['success'] = "Xóa sp có id = $id khỏi giỏ hàng thành công";
        $url_redirect = $_SERVER['SCRIPT_NAME']."/gio-hang-cua-ban.html";
//      /PHP/Day37_Demo_Website_Part_7_Cart_Payment_Laravel/mvc_project/frontend/index.php/gio-hang-cua-ban.html
        header("Location: $url_redirect");
        exit();

    }
}