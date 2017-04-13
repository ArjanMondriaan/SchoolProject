<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class InstructeurModel extends \ao\php\framework\models\AbstractModel
{
            
    public function __construct( $control, $action)// vanuit bezoekercontroller wordt het recht opgehaald en automatisch ingevuld
    {
        parent::__construct($control, $action);
    }
    
    public function getLessen()
    {
       $sql = 'SELECT * FROM `lessons`';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $s = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
       return $s;
    }
}
