<?php
//controllers/Controller.php
class Controller
{
    // KHai báo phương thức khởi tạo cho controller cha
    public function __construct() {
        // Do tất cả các controller đều kế thừa từ controller, nên lợi dùng phương thức khởi tạo
        // để xử lý logic chặn truy cập khi user chưa đăng nhập vào hệ thống
        // + Dựa vào session user để ktra xem user đã đăng nhập thành công hay chưa, loại trừ 2 chức năng
        //mà ko cần login vẫn truy cập là: đăng ký và đăng nhập
        if (!isset($_SESSION['user'])
            && $_GET['controller'] != 'user'
            && !in_array($_GET['action'], ['register', 'login'])) {
//      $this->error = 'Bạn chưa đăng nhập';
            header('Location: index.php?controller=login&action=login');
            exit();
        }
    }

    //chứa nội dung view
    public $content;
    //chứa nội dung lỗi validate
    public $error;

    // Tiêu đề trang
    public $page_title;

    /**
     * @param $file string Đường dẫn tới file
     * @param array $variables array Danh sách các biến truyền vào file
     * @return false|string
     */
    // Khai báo 1 phương thức dùng để lấy nội dung của 1 file bất kỳ, kèm theo cơ chế truyền biến
    //tường mình vào file đó để sử dụng -> lấy nội dung động của view
    // $file_path: đường dẫn tới file muốn lấy nội dung
    // $variables: mảng chứa các biến sẽ truyền ra file để sử dụng
    public function render($file, $variables = []) {

        //Nhập các giá trị của mảng vào các biến có tên tương ứng chính là key của phần tử đó.
        //khi muốn sử dụng biến từ bên ngoài vào trong hàm
        extract($variables);
        //bắt đầu nhớ mọi nội dung kể từ khi khai báo, kiểu như lưu vào bộ nhớ tạm
        ob_start();
        //thông thường nếu ko có ob_start thì sẽ hiển thị 1 dòng echo lên màn hình
        //tuy nhiên do dùng ob_Start nên nội dung của nó đã đc lưu lại, chứ ko hiển thị ra màn hình nữa
        require $file;
        //lấy dữ liệu từ bộ nhớ tạm đã lưu khi gọi hàm ob_Start để xử lý, lấy xong rồi xóa luôn dữ liệu đó
        $render_view = ob_get_clean();

        return $render_view;
    }
}