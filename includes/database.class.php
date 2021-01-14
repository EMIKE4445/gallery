<?php
    
class database {
    private $host='localhost';
    private $username='root';
    private $password ='';
    private $dbname='gallery';


    protected function connect(){
                  
      try{
        $dsn ="mysql:host=$this->host;dbname=$this->dbname";
        // echo $dsn;
        $conn =new pdo($dsn,$this->username,$this->password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
      }catch(\Exception $e){
        $dsn ="mysql:host=$this->host;";
        $conn =new pdo($dsn,$this->username,$this->password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  
        $this->create_db($conn);
        $this->create_user_table($conn);
        $this->create_image_table($conn);
        return $conn;

      }
    }

    private function create_db($conn){
      $sql="CREATE DATABASE IF NOT EXISTS gallery";
      $conn->query($sql);
      $conn->query("use gallery");
      //$result=$prep->execute();
    }

    private function create_user_table($conn){
      $sql="create table users(
        id int primary key not null AUTO_INCREMENT,
        username varchar(20) not null,
        email varchar(30) not null,
        user_password varchar(80) not null
      );";


      $conn->query($sql);
    }

    private function create_image_table($conn){
      $sql="create table images(
        id int primary key not null AUTO_INCREMENT,
        image_name varchar(20) not null,
        user_id int references users(id),
        posted_at timestamp default current_timestamp not null
    
      );";


      $conn->query($sql);
    }
}

?>