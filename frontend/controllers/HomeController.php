<?php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Categoryy.php';
require_once 'models/Pagination.php';

class HomeController extends Controller {
    public function index() {
        $product_model = new Product();
        $params = [
            'limit' => 4,
            'query_string' => 'page',
            'controller' => 'home',
            'action' => 'index',
            'full_mode' => FALSE,
        ];
        $page = 1;
        //nếu có truyền tham số page lên trình duyêt - tương đương đang ở tại trang nào, thì gán giá trị đó cho biến $page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $params['page'] = $page;
        $count_total = $product_model->countTotal();
        $params['total'] = $count_total;
        //xử lý phân trang
        $pagination_model = new Pagination($params);
        $pagination = $pagination_model->getPagination();
//        $product_model = new Product();
        $products = $product_model->getProductInHomePage($params);
        $category_model = new Categoryy();
        $categories = $category_model->getAll();


        $this->content = $this->render('views/homes/index.php', [
            'products' => $products,
            'categories' => $categories,
            'pagination' => $pagination

        ]);
        require_once 'views/layouts/main.php';
    }

    // Chức năng tìm kiếm sản phẩm
    public function search() {
        // Lấy ra thông tin từ URL
        //frontend/index.php?search=dsa&controller=product&action=search
//    echo "<pre>";
//    print_r($_GET);
//    echo "</pre>";
        $search = $_GET['name'];

        $product_model = new Product();

        $params = [
            'limit' => 2,
            'query_string' => 'page',
            'controller' => 'home',
            'action' => 'search',
            'full_mode' => FALSE,
        ];
        $page = 1;
        //nếu có truyền tham số page lên trình duyêt - tương đương đang ở tại trang nào, thì gán giá trị đó cho biến $page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $params['page'] = $page;
        $count_total = $product_model->countTotal();
        $params['total'] = $count_total;
        //xử lý phân trang
        $pagination_model = new Pagination($params);
        $pagination = $pagination_model->getPagination();

        // Gọi model để truy vấn CSDL, lấy ra các sp có tên chứa từ khóa search
        $product_model = new Product();
        $products = $product_model->getProductSearch($params);
//    echo "<pre>";
//    print_r($products);
//    echo "</pre>";
        if(empty($products)){
            $this->error = "Không có sản phẩm nào có chứa tên " .$search;
        }

        // Lấy nội dung view:
        $this->content = $this->render('views/homes/index.php',[
            'products' => $products,
            'pagination' => $pagination
        ]);
        // Gọi layout để hiển thị view
        require_once 'views/layouts/main.php';
    }

    public function filterProduct(){

        $filter = (int)$_GET['filter'];
        $product_model = new Product();
        $params = [
            'limit' => 2,
            'query_string' => 'page',
            'controller' => 'home',
            'action' => 'filterProduct',
            'full_mode' => FALSE,
        ];
        $page = 1;
        //nếu có truyền tham số page lên trình duyêt - tương đương đang ở tại trang nào, thì gán giá trị đó cho biến $page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $params['page'] = $page;
        $count_total = $product_model->countTotal();
        $params['total'] = $count_total;
        //xử lý phân trang
        $pagination_model = new Pagination($params);
        $pagination = $pagination_model->getPagination();

        $products = $product_model->getProductFilter($filter,$params);
        $this->content = $this->render('views/homes/index.php', [
            'products' => $products,
            'pagination' => $pagination

        ]);
        require_once 'views/layouts/main.php';
    }
}