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
    
    
}
