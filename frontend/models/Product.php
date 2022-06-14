<?php
//models/Product.php;
require_once 'models/Model.php';
class Product extends Model {
    /*
     * Chuỗi search, sinh tự động dựa vào tham số GET trên Url
     */
    public $str_search = '';

    public function __construct()
    {
        parent::__construct(); // gọi đến __construct() của class cha mà nó kế thừa (Class Model)
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $this->str_search .= " AND products.title LIKE '%{$_GET['name']}%'";
        }
        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $this->str_search .= " AND  products.category_id = {$_GET['filter']}";
        }
    }

    // Lấy sản phẩm có tên chứa từ khóa $search
    public function getProductSearch($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        // + Viết truy vấn dạng tham só: SQL Injection
        // Ký tự % đại diện cho ký tứ bất kỳ trong MySQL
        // sam -> sam, abcsam, ípsam123
        $sql_select_all = "SELECT products.*, categories.name AS category_name FROM products 
                        INNER JOIN categories ON categories.id = products.category_id
                      $this->str_search
                       LIMIT $start, $limit";
        // + Cbi obj truy vấn: prepare
        $obj_select_all = $this->connection->prepare($sql_select_all);

        // + Thực thị obj truy vấn: execute
        $obj_select_all->execute();
        // + Trả về mảng kết hợp
        $products = $obj_select_all->fetchAll(PDO::FETCH_ASSOC);
        return $products;
        // Test lại chức năng tìm kiếm

    }

    public function getProductFilter($id,$params = []){
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $sql_select_all = "SELECT products.*, categories.name AS category_name FROM products 
                        INNER JOIN categories ON categories.id = products.category_id
                       WHERE categories.id = :id 
                       LIMIT $start, $limit";
        // + Cbi obj truy vấn: prepare
        $obj_select_all = $this->connection->prepare($sql_select_all);
        $selects = [
            ':id' => $id
        ];
        $obj_select_all->execute($selects);
        $products = $obj_select_all->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function countTotal()
    {
        $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM products WHERE TRUE $this->str_search ");
        $obj_select->execute();

        return $obj_select->fetchColumn();
    }

    public function getProductInHomePage($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $str_filter = '';
        if (isset($params['category'])) {
            $str_category = $params['category'];
            $str_filter .= " AND categories.id IN $str_category";
        }
        if (isset($params['price'])) {
            $str_price = $params['price'];
            $str_filter .= " AND $str_price";
        }
        //do cả 2 bảng products và categories đều có trường name, nên cần phải thay đổi lại tên cột cho 1 trong 2 bảng
        $sql_select = "SELECT products.*, categories.name 
          AS category_name FROM products
          INNER JOIN categories ON products.category_id = categories.id
          WHERE products.status = 1 $str_filter LIMIT $start, $limit";

        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute();

        $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    /**
     * Lấy thông tin sản phẩm theo id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $obj_select = $this->connection
            ->prepare("SELECT products.*, categories.name AS category_name FROM products 
          INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id");
        $selects = [
            ':id' => $id
        ];

        $obj_select->execute($selects);
        $product =  $obj_select->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getAllProductByCategory($id_category) {
        //tạo câu truy vấn
        //gắn chuỗi search nếu có vào truy vấn ban đầu
        $sql_select_all = "SELECT * FROM products where category_id = :id_category";
//        $sql_select_all = "SELECT * FROM categories $this->str_search";
        //cbi đối tượng truy vấn
        $obj_select_all = $this->connection
            ->prepare($sql_select_all);
        $obj_select_all->execute($selects = [
            ':id_category' => $id_category
        ]);
        $products = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
}

