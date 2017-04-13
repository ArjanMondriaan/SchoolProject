<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class InstructeurModel extends \ao\php\framework\models\AbstractModel
{
            
    public function __construct( $control, $action)// vanuit bezoekercontroller wordt het recht opgehaald en automatisch ingevuld
    {
        parent::__construct($control, $action);
    }
    public function getSoortenLessen()
    {
       $sql = 'SELECT * FROM `lessons`';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $s = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Lessons');    
       return $s;
    }
    public function wijzigLes() {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $time = filter_input(INPUT_POST, 'time');
        $date= filter_input(INPUT_POST, 'date');
        $location= filter_input(INPUT_POST, 'location');
        $maxpersons= filter_input(INPUT_POST, 'maxpersons');
        
        if($time===null || $date===null || $location===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $sql="UPDATE `lessons` SET time=:time,date=:date,location=:location,maxpersons=:maxpersons where `lessons`.`id`= :id; ";

        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);        
        $stmnt->bindParam(':time', $time);
        $stmnt->bindParam(':date', $date);
        $stmnt->bindParam(':location', $location);
        $stmnt->bindParam(':maxpersons', $maxpersons); 
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            echo $e;
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    public function editLes() 
    {
        $id= filter_input(INPUT_GET,'id');
        $sql = "SELECT * FROM lessons WHERE id=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        $lessenInfo = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Lessons');    
        return $lessenInfo[0];
    }
    public function AddLes() {
        $time = filter_input(INPUT_POST, 'time');
        $date= filter_input(INPUT_POST, 'date');
        $location= filter_input(INPUT_POST, 'location');
        $maxpersons= filter_input(INPUT_POST, 'maxpersons');
        $instructeurs= filter_input(INPUT_POST, 'instructeur');
        $les= filter_input(INPUT_POST, 'training');
        
        if($time===null || $date===null || $location===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        

        $sql="INSERT INTO `lessons` (time,date,location,maxpersons,personid,trainingid) VALUES (:time,:date,:location,:maxpersons,:instructeur,:les)";

        $stmnt = $this->dbh->prepare($sql);  
        $stmnt->bindParam(':time', $time);
        $stmnt->bindParam(':date', $date);
        $stmnt->bindParam(':location', $location);
        $stmnt->bindParam(':maxpersons', $maxpersons);
        $stmnt->bindParam(':instructeur', $instructeurs);
        $stmnt->bindParam(':les', $les);  
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            echo $e;
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    public function getInstructeurs(){
        
        $sql = "SELECT * FROM persons where role = 'Instructeur'";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->execute();
        $Instructeurs = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');    
        return $Instructeurs;
    }
    public function getTrainingen(){
        $sql = "SELECT * FROM training";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->execute();
        $trainingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
        return $trainingen;
    }
    public function deleteLes()
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
       
        $sql = "DELETE FROM `lessons` WHERE `lessons`.`id`=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
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
    
   public function uitloggen()
   {
       
   }
}
