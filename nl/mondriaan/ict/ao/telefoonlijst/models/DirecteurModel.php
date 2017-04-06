<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

/**
 * Description of DirecteurModel
 *
 * @author KOOH02
 */
class DirecteurModel extends \ao\php\framework\models\AbstractModel
{
            
    public function __construct( $control, $action)// vanuit bezoekercontroller wordt het recht opgehaald en automatisch ingevuld
    {
        parent::__construct($control, $action);
    }
    public function getContacten()
    {
        $sql = 'SELECT `contacten`.*, `afdelingen`.`naam` AS afdelings_naam, `afdelingen`.`afkorting` '
                . 'AS afdelings_afkorting FROM `contacten`, `afdelingen` '
                . 'WHERE `contacten`.`recht`=\'medewerker\' '
                . 'AND `afdelingen`.`id`=`contacten`.`afdelings_id` '
                . 'ORDER BY afdelings_afkorting DESC, achternaam ASC';
        
        try
        {
            $stmnt = $this->dbh->prepare($sql);
            $stmnt->execute();
            if(count($stmnt)===1)
            {
                $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__.'\db\COntact');
                return $contacten;
            }
            return  REQUEST_FAILURE_DATA_INVALID;
        } 
        catch (PDOException $ex) 
        {
            return  REQUEST_FAILURE_DATA_INVALID;
        }
   
        
    }
    public function getAfdelingen()
    {
        $sql = 'SELECT * FROM `afdelingen` ORDER BY afkorting ASC';
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->execute();
        $afdelingen = $stmnt->fetchAll(\PDO::FETCH_CLASS, __NAMESPACE__.'\db\Afdeling');
        return $afdelingen;
        
    }
}
