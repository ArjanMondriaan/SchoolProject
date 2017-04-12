<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class LidModel extends \ao\php\framework\models\AbstractModel
{   
    public function __construct($control, $action)
    {   
        parent::__construct($control, $action);
    }
    
    public function isGerechtigd()
    {
        //controleer of er ingelogd is. Ja, kijk of de gebuiker deze controller mag gebruiken 
        if(isset($_SESSION['gebruiker'])&&!empty($_SESSION['gebruiker']))
        {
            $gebruiker=$_SESSION['gebruiker'];
            if ($gebruiker->getRole() == "lid")
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;     
   }
   
   public function getGebruiker()
   {
       return $_SESSION['gebruiker'];
   }
   
   public function uitloggen()
   {
       $_SESSION = array();
       session_destroy();
   }
   
    
    function isPostLeeg()
    {
       return empty($_POST);
    }
    
    public function getGegevens(){
        $sql = 'SELECT * FROM `persons` WHERE id = :id';
         
        $stmnt = $this->dbh->prepare($sql);
        $gebruiker=$this->getGebruiker();
        $id = $gebruiker->getId();
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $gegevens = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__.'\db\Contact');
       
        return $gegevens[0];
    }
    
    public function wijzigGegevens(){

            $straat=filter_input(INPUT_POST, 'straat');
            $postcode=filter_input(INPUT_POST, 'postcode');
            $stad=filter_input(INPUT_POST, 'stad');
            $email= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            
                $sql="UPDATE `persons` SET street=:straat"
            . ",postalcode=:postcode,place=:stad,"
             . "emailaddress=:email where `persons`.`id`= '1' ";
            
            $stmnt = $this->dbh->prepare($sql);
            $stmnt->bindParam(':straat', $straat);
            $stmnt->bindParam(':postcode', $postcode);
            $stmnt->bindParam(':stad', $stad);
            $stmnt->bindParam(':email', $email);
            try
            {
                $stmnt->execute();
            }
            catch(\PDOEXception $e)
            {
                return REQUEST_FAILURE_DATA_INVALID;
            }

            if($stmnt->rowCount()===1)
            {
                return REQUEST_SUCCESS;
                
            }
            return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    public function getAlleActiviteiten()
    {
        $sql='SELECT * FROM lessons';

        $stmnt = $this->dbh->prepare($sql);
        $stmnt->execute();
        $activiteiten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling');    
        return $activiteiten;
    }
}
