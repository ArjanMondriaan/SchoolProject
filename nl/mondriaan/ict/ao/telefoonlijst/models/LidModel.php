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
             . "emailaddress=:email where `persons`.`id`= :id ";
            
            $stmnt = $this->dbh->prepare($sql);
            $gebruiker=$this->getGebruiker();
            $id = $gebruiker->getId();
            $stmnt->bindParam(':id', $id);
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
    
    public function getBeschikbareLessen()
    {
        $sql='SELECT DATE_FORMAT(`lessons`.`date`, "%d-%m-%Y") as `date`, 
           DATE_FORMAT(`lessons`.`time`,"%H:%i") as `time`, 
           `training`.`extra_costs`, 
           `lessons`.`id` as `id`, 
           `training`.`description` 
           FROM `lessons` 
           JOIN `training` on `lessons`.`trainingid` = `training`.`id` 
           WHERE `lessons`.`id` NOT IN (SELECT lessonid FROM `registrations` 
                                    WHERE `registrations`.`personid`=:id)
             order by  DATE(`lessons`.`date`)';
            
       $stmnt = $this->dbh->prepare($sql);
       $id=$this->getGebruiker()->getId();
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $beschikbareLessen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling');    
       return $beschikbareLessen;
    }
    
    public function addDeelname()
    {
       $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        
       if($id===null)
       {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
       }
       if($id===false)
       {
            return REQUEST_FAILURE_DATA_INVALID;
       }   
        
       $sql="INSERT INTO `registrations`  (personid,lessonid)VALUES (:personid,:lessonid) ";
       $deelnemer=$this->getGebruiker()->getId();
               
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->bindParam(':personid', $deelnemer);
       $stmnt->bindParam(':lessonid', $id);
              
       try
       {
            $stmnt->execute();
       }
       catch(\PDOEXception $e)
       {
            return REQUEST_FAILURE_DATA_INVALID;
       }
       
       return REQUEST_SUCCESS;
    }
    
    public function getIngeschrevenLessen(){
        $sql='SELECT DATE_FORMAT(`lessons`.`date`, "%d-%m-%Y") as `date`, 
           DATE_FORMAT(`lessons`.`time`,"%H:%i") as `time`, 
           `training`.`extra_costs`, 
           `lessons`.`id`, 
           `training`.`description`
           FROM `lessons` 
            JOIN `training` on `lessons`.`trainingid` = `training`.`id`
            WHERE `lessons`.`id` IN (SELECT lessonid FROM `registrations` 
                                    WHERE `registrations`.`personid`=:id)
            order by  DATE(`lessons`.`date`)';
                
       $stmnt = $this->dbh->prepare($sql);
       $id=$this->getGebruiker()->getId();
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $ingeschrevenLessen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling');    
       return $ingeschrevenLessen;
    }
    
    public function deleteDeelnameActiviteit()
    {
        $activiteit_id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $deelnemer_id= $this->getGebruiker()->getId();
        if($activiteit_id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($activiteit_id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }   
       
        $sql = "DELETE FROM `registrations` WHERE `lessonid`=:lessonid and `personid`=:personid";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':lessonid', $activiteit_id); 
        $stmnt->bindParam(':personid', $deelnemer_id);
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
       
        if($stmnt->rowCount()===1){
           
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function getAantalDeelnemers()
    {
       $sql='select registrations.lessonid, count(*) as aantal_deelnemers, lessons.maxpersons FROM registrations JOIN lessons on registrations.lessonid=lessons.id GROUP BY registrations.lessonid';          
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $aantalDeelnemers = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling');    
       return $aantalDeelnemers;
    }
}
