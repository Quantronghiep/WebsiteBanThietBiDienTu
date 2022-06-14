<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 5/9/2022
 * Time: 12:20 AM
 */
require_once 'models/Model.php';

class Categoryy extends Model
{
    public function getAll() {
        //tạo câu truy vấn
        //gắn chuỗi search nếu có vào truy vấn ban đầu
        $sql_select_all = "SELECT * FROM categories  WHERE `status` = 1";
//        $sql_select_all = "SELECT * FROM categories $this->str_search";
        //cbi đối tượng truy vấn
        $obj_select_all = $this->connection
            ->prepare($sql_select_all);
        $obj_select_all->execute();
        $categories = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
}