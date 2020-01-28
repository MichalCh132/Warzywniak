<?php
class Cart{
    private $connection;
    public $table_name;

    public $id_cart;
    public $id_user;
    public $date;

    public function __construct($db){
        $this->connection = $db;
        $this->table_name = "carts";
    }
function create(){
 $this->date=date("Y-m-d H:i:s");
 $query = "INSERT INTO
             " . $this->table_name . "
         SET
            data='$this->date', id_user=:id_user";

 $stmt = $this->connection->prepare($query);

 $this->id_user=htmlspecialchars(strip_tags($this->id_user));

 $stmt->bindParam(":id_user", $this->id_user);

 if($stmt->execute()){
     return true;
 }

 return false;
  
}

function readOneByIdUser(){
        $query = "SELECT id_cart,data
                  FROM
                    " . $this->table_name . " 
                  WHERE id_user
                   = '$this->id_user' 
                   && data=(SELECT max(data) from " . $this->table_name . " where id_user ='$this->id_user')";
        $stmt = $this->connection->prepare( $query );
     
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id_cart = $row['id_cart'];
        $this->date = $row['data'];
    
}

function read_history(){

    $query = "SELECT c.data,p.quantity,p.price,i.name 
    from carts c 
    left join cart_positions p 
    on c.id_cart = p.id_cart 
    inner join items i 
    on i.id_item = p.id_item
    where c.id_user = $this->id_user
    order by c.data";
 
    $stmt = $this->connection->prepare($query);
 
    $stmt->execute();
 
    return $stmt;

}


}

?>