<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class MedewerkerModel extends \ao\php\framework\models\AbstractModel
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
            if ($gebruiker->getRecht() == "medewerker")
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
   
    public function wijzigAnw()
    {
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $intern=filter_input(INPUT_POST,'int');
        $extern=filter_input(INPUT_POST,'ext');
        
        if(empty($email))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if($email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $gebruiker_id = $this->getGebruiker()->getId();
        
        $sql="UPDATE `telefoonlijst`.`contacten` SET extern=:extern,intern=:intern,email=:email where `contacten`.`id`= :gebruiker_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':extern', $extern);
        $stmnt->bindParam(':intern', $intern);
        $stmnt->bindParam(':email', $email);     
        $stmnt->bindParam(':gebruiker_id', $gebruiker_id);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            $this->updateGebruiker();
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    private function updateGebruiker() 
    {
       $gebruiker_id = $this->getGebruiker()->getId();
       $sql = "SELECT * FROM `contacten` WHERE `contacten`.`id`=:gebruiker_id";
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->bindParam(':gebruiker_id', $gebruiker_id);
       $stmnt->setFetchMode(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');   
       $stmnt->execute();
       $_SESSION['gebruiker']= $stmnt->fetch(\PDO::FETCH_CLASS);
    }
    function isPostLeeg()
    {
       return empty($_POST);
    }
    
     public function wijzigFoto() 
    {    
        $fotoNaam = FOTO::getAfbeeldingNaam();//bedenk een naam voor de foto.
        
        $result = FOTO::slaAfbeeldingOp($fotoNaam);//sla foto op
        if($result === false)
        {
            return IMAGE_FAILURE_SAVE_FAILED;
        }
        $id = $this->getGebruiker()->getId();
        //binding onnodig alle gegevens zijn serverside en niet clientside :-)
        $sql = "UPDATE `contacten` SET `contacten`.`foto`= '$fotoNaam' WHERE `contacten`.`id`= :id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd === 1)
        {
            $oudeFoto = $this->getGebruiker()->getFoto();
            $this->updateGebruiker();
            FOTO::verwijderAfbeelding($oudeFoto);
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
}
