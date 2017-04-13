<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class InstructeurModel extends \ao\php\framework\models\AbstractModel
{
            
    public function __construct( $control, $action)// vanuit bezoekercontroller wordt het recht opgehaald en automatisch ingevuld
    {
        parent::__construct($control, $action);
    }
    
    public function getSoortenTraining()
    {
       $sql = 'SELECT * FROM `training`';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $s = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
       return $s;
    }
    public function wijzigSoortTraining() {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $description = filter_input(INPUT_POST, 'description');
        $duration= filter_input(INPUT_POST, 'duration');
        $extra_costs= filter_input(INPUT_POST, 'extra_costs');
        $naam= filter_input(INPUT_POST, 'naam');
        
        if($description===null || $duration===null || $extra_costs===null || $naam===null )
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }

        $sql="UPDATE `training` SET description=:desc,duration=:duration,extra_costs=:extra,name=:naam where `training`.`id`= :id; ";

        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);        
        $stmnt->bindParam(':desc', $description);
        $stmnt->bindParam(':duration', $duration);
        $stmnt->bindParam(':extra', $extra_costs);
        $stmnt->bindParam(':naam', $naam); 
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
    public function editSoortTraining() 
    {
        $id= filter_input(INPUT_GET,'id');
        $sql = "SELECT * FROM training WHERE id=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        $TrainingInfo = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
        return $TrainingInfo[0];
    }
    public function AddSoortTraining() {
        $description = filter_input(INPUT_POST, 'description');
        $duration= filter_input(INPUT_POST, 'duration');
        $extra_costs= filter_input(INPUT_POST, 'extra_costs');
        $naam= filter_input(INPUT_POST, 'naam');
        
        if($description===null || $duration===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        

        $sql="INSERT INTO `training` (description,duration,extra_costs,name) VALUES (:desc,:duration,:extra,:naam)";

        $stmnt = $this->dbh->prepare($sql);  
        $stmnt->bindParam(':desc', $description);
        $stmnt->bindParam(':duration', $duration);
        $stmnt->bindParam(':extra', $extra_costs);
        $stmnt->bindParam(':naam', $naam);
           
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
    
    public function deleteSoortTraining()
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
       
        $sql = "DELETE FROM `training` WHERE `training`.`id`=:id";
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
