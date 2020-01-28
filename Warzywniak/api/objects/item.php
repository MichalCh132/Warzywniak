<?php
class Item{
    private $connection;
    public $table_name;

    public $id_item;
    public $name;
    public $price;
    public $describe;
    public $image;
    public $available;

    public function __construct($db){
        $this->connection = $db;
        $this->table_name = "items";
    }
    function read(){
     
        $query = "SELECT * from items";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

function readOne(){
 
    $query = "SELECT
               id_item,name,price,`describe`,image,available
              FROM
                " . $this->table_name . " 
              WHERE id_item = ?";
 
    $stmt = $this->connection->prepare( $query );
 
    $stmt->bindParam(1, $this->id_item);
 
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->describe = $row['describe'];
    $this->image = $row['image'];
    $this->available = $row['available'];
}

function create(){
 
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, `describe`=:describe, available=:available";
 
    $stmt = $this->connection->prepare($query);
 
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->describe=htmlspecialchars(strip_tags($this->describe));
    $this->available=htmlspecialchars(strip_tags($this->available));
 
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":describe", $this->describe);
    $stmt->bindParam(":available", $this->available);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
function update(){
 
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                `describe` = :describe,
                available = :available
            WHERE
                id_item = :id_item";
 
    $stmt = $this->connection->prepare($query);

    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->describe=htmlspecialchars(strip_tags($this->describe));
    $this->id_item=htmlspecialchars(strip_tags($this->id_item));
    $this->available=htmlspecialchars(strip_tags($this->available));
 
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':describe', $this->describe);
    $stmt->bindParam(':available', $this->available);
    $stmt->bindParam(':id_item', $this->id_item);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
function delete(){
    $query = "DELETE FROM " . $this->table_name . " WHERE id_item = $this->id_item";
    $stmt = $this->connection->prepare($query);
 
    $this->id_item=htmlspecialchars(strip_tags($this->id_item));
    $stmt->bindParam(':id_item', $this->id_item);
    echo $this->id_item;
    echo $query;
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}
?>