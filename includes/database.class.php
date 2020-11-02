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
                      echo $e->getmessage();

                  }
                }
    }

?>