<?php
class User{
    private $connection;
    public $table_name;

    public $id_user;
    public $name;
    public $email;
    public $phone;
    public $password;

    public function __construct($db){
        $this->connection = $db;
        $this->table_name = "users";
    }

    function read(){
     
        $query = "SELECT * from users";
    
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function readOne(){
        $query = "SELECT
                   id_user,name,phone,password,email
                  FROM
                    " . $this->table_name . " 
                  WHERE id_user
                   = ?";
     
        $stmt = $this->connection->prepare( $query );
     
        $stmt->bindParam(1, $this->id_user);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->phone = $row['phone'];
        $this->password = $row['password'];
        $this->email = $row['email'];
    }

    function readOneByEmail($email){
        $query = "SELECT
                   id_user,name,phone,password,email
                  FROM
                    " . $this->table_name . " 
                  WHERE email
                   = '$email'";
     
        $stmt = $this->connection->prepare( $query );
     
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->phone = $row['phone'];
        $this->password = $row['password'];
        $this->id_user = $row['id_user'];
    }

function update(){
 
    $query = "UPDATE
                " . $this->table_name . "
            SET
                `name` = :name,
                `email` = :email,
                `phone` = :phone,
                `password` = :password
            WHERE
                `id_user` = :id_user";
 
    $stmt = $this->connection->prepare($query);
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->id_user=htmlspecialchars(strip_tags($this->id_user));
 
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(':id_user', $this->id_user);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, email=:email, `phone`=:phone, password=:password";
     
        $stmt = $this->connection->prepare($query);
     
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->password=htmlspecialchars(strip_tags($this->password));
     
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":password", $this->password);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }

function delete(){
    
    $query = "DELETE FROM " . $this->table_name . " WHERE id_user = $this->id_user";
    
    $stmt = $this->connection->prepare($query);
 
    $this->id_user=htmlspecialchars(strip_tags($this->id_user));
    $stmt->bindParam(':id_user', $this->id_user);
    
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

} ?>