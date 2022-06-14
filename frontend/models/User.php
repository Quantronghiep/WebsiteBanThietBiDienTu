<?php
require_once 'models/Model.php';

class User extends Model
{
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  public $phone;
  public $address;
  public $email;
  public $avatar;
  public $jobs;
  public $last_login;
  public $facebook;
  public $isAdmin;
  public $status;
  public $created_at;
  public $updated_at;

  public $str_search;

  public function __construct()
  {
    parent::__construct();
    if (isset($_GET['name']) && !empty($_GET['name'])) {
      $username = addslashes($_GET['name']);
      $this->str_search .= " AND users.username LIKE '%$username%'";
    }
  }
  //Hàm addlash () trả về một chuỗi có dấu gạch chéo ngược phía trước các ký tự : ',",\,NULL

  public function getAll()
  {
    $obj_select = $this->connection
      ->prepare("SELECT * FROM users ORDER BY updated_at DESC, created_at DESC");
    $obj_select->execute();
    $users = $obj_select->fetchAll(PDO::FETCH_ASSOC);

    return $users;
  }

  public function register() {
    // + Viết truy vấn
    $sql_insert = "
  INSERT INTO users(username, password,isAdmin) 
  VALUES(:username, :password,0)";
    // + Cbi obj truy vấn
    $obj_insert = $this->connection
      ->prepare($sql_insert);
    // + Tạo mảng
    $inserts = [
      ':username' => $this->username,
      ':password' => $this->password,
    ];
    // + Thực thi
    $is_insert = $obj_insert->execute($inserts);
    return $is_insert;
  }

  public function getUser($username)
  {
    $sql_select_one =
      "SELECT * FROM users WHERE username = :username";
    $obj_select_one = $this->connection
      ->prepare($sql_select_one);
    $selects = [
      ':username' => $username
    ];
    $obj_select_one->execute($selects);
    $user = $obj_select_one
      ->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

    public function getUserIsUser($username)
    {
        $sql_select_one =
            "SELECT * FROM users WHERE isAdmin = 0 and username = :username";
        $obj_select_one = $this->connection
            ->prepare($sql_select_one);
        $selects = [
            ':username' => $username
        ];
        $obj_select_one->execute($selects);
        $user = $obj_select_one
            ->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

  public function getAllPagination($params = [])
  {
    $limit = $params['limit'];
    $page = $params['page'];
    $start = ($page - 1) * $limit;
    $obj_select = $this->connection
      ->prepare("SELECT * FROM users WHERE TRUE $this->str_search
              ORDER BY created_at DESC
              LIMIT $start, $limit");

    $obj_select->execute();
    $users = $obj_select->fetchAll(PDO::FETCH_ASSOC);

    return $users;
  }

  public function getTotal()
  {
    $obj_select = $this->connection
      ->prepare("SELECT COUNT(id) FROM users WHERE TRUE $this->str_search");
    $obj_select->execute();
    return $obj_select->fetchColumn();
  }

  public function getById($id)
  {
    $obj_select = $this->connection
      ->prepare("SELECT * FROM users WHERE id = :id");
    $selects = [
          ':id' => $id
    ];
    $obj_select->execute($selects);
    return $obj_select->fetch(PDO::FETCH_ASSOC);
  }

  //Số user theo username
  public function getUserByUsername($username)
  {
    $obj_select = $this->connection
      ->prepare("SELECT COUNT(id) FROM users WHERE username= :username");
    $selects = [
          ':username' => $username
    ];
    $obj_select->execute($selects);
    return $obj_select->fetchColumn();
  }

  public function checkId($id){
      $obj_select = $this->connection
          ->prepare("SELECT COUNT(id) FROM users WHERE id = :id");
      $selects = [
          ':id' => $id
      ];
      $obj_select->execute($selects);
      return $obj_select->fetchColumn();
  }

  public function updateLastLogin($username){
      $obj_update = $this->connection->prepare(
          "UPDATE users SET last_login=:last_login WHERE username = :username"
      );
      $arr_update = [
        ':last_login' => $this->last_login,
          ':username' => $username
      ];

      return  $obj_update->execute($arr_update);
  }

  public function insert()
  {
    $obj_insert = $this->connection
      ->prepare("INSERT INTO users(username, password, first_name, last_name, phone, address, email, avatar, jobs, facebook,isAdmin, status)
VALUES(:username, :password, :first_name, :last_name, :phone, :address, :email, :avatar, :jobs, :facebook,:isAdmin, :status)");
    $arr_insert = [
      ':username' => $this->username,
      ':password' => $this->password,
      ':first_name' => $this->first_name,
      ':last_name' => $this->last_name,
      ':phone' => $this->phone,
      ':address' => $this->address,
      ':email' => $this->email,
      ':avatar' => $this->avatar,
      ':jobs' => $this->jobs,
      ':facebook' => $this->facebook,
        ':isAdmin' => $this->isAdmin,
      ':status' => $this->status,
    ];
    return $obj_insert->execute($arr_insert);
  }

  public function update($id)
  {
    $obj_update = $this->connection
      ->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name, phone=:phone, 
            address=:address, email=:email, avatar=:avatar, jobs=:jobs, facebook=:facebook,isAdmin =:isAdmin, status=:status, updated_at=:updated_at
             WHERE id = :id");
    $arr_update = [
      ':first_name' => $this->first_name,
      ':last_name' => $this->last_name,
      ':phone' => $this->phone,
      ':address' => $this->address,
      ':email' => $this->email,
      ':avatar' => $this->avatar,
      ':jobs' => $this->jobs,
      ':facebook' => $this->facebook,
        ':isAdmin' => $this->isAdmin,
      ':status' => $this->status,
      ':updated_at' => $this->updated_at,
        ':id' => $id
    ];
    $obj_update->execute($arr_update);

    return $obj_update->execute($arr_update);
  }

  public function delete($id)
  {
    $obj_delete = $this->connection
      ->prepare("DELETE FROM users WHERE id = :id");
    $deletes = [
            ':id' => $id
    ];
    return $obj_delete->execute($deletes);
  }

  public function getUserByUsernameAndPassword($username, $password)
  {
    $obj_select = $this->connection
      ->prepare("SELECT * FROM users WHERE username=:username AND password=:password LIMIT 1");
    $arr_select = [
      ':username' => $username,
      ':password' => $password,
    ];
    $obj_select->execute($arr_select);

    $user = $obj_select->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  public function insertRegister()
  {
    $obj_insert = $this->connection
      ->prepare("INSERT INTO users(username, password, status)
VALUES(:username, :password, :status)");
    $arr_insert = [
      ':username' => $this->username,
      ':password' => $this->password,
      ':status' => $this->status,
    ];
    return $obj_insert->execute($arr_insert);
  }

}