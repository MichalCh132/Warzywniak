<?php
class Cart_position{
    private $connection;
    public $table_name;

    public $id_cart_positions;
    public $quantity;
    public $price;
    public $id_cart;
    public $id_item;

    public function __construct($db){
        $this->connection = $db;
        $this->table_name = "cart_positions";
    }
function create(){
 $query = "INSERT INTO
             " . $this->table_name . "
         SET
            quantity=:quantity,price=:price,id_cart=:id_cart,id_item=:id_item";

 $stmt = $this->connection->prepare($query);

 $this->quantity=htmlspecialchars(strip_tags($this->quantity));
 $this->price=htmlspecialchars(strip_tags($this->price));
 $this->id_cart=htmlspecialchars(strip_tags($this->id_cart));
 $this->id_item=htmlspecialchars(strip_tags($this->id_item));

 $stmt->bindParam(":quantity", $this->quantity);
 $stmt->bindParam(":price", $this->price);
 $stmt->bindParam(":id_cart", $this->id_cart);
 $stmt->bindParam(":id_item", $this->id_item);

 if($stmt->execute()){
     return true;
 }

 return false;
  
}
function read_by_cart(){
     
    $query = "SELECT * from cart_positions where id_cart = $this->id_cart";
 
    $stmt = $this->connection->prepare($query);
 
    $stmt->execute();
 
    return $stmt;

}
}