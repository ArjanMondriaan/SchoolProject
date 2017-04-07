<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

class BezoekerController extends \ao\php\framework\controls\AbstractController
{
    
    public function __construct($control,$action, $message=NULL)
    {
        parent::__construct($control, $action);
    }

    /**
    * execute vertaalt de action variable dynamisch naar een handler van de specifieke controller.
    * als de handler niet bestaat wordt de default als action ingesteld en
    * wordt de taak overgedragen aan de defaultAction handler. defaultAction bestaat altijd wel.
    */
    
    protected function registrerenAction()
    {
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Vul uw gegevens in");
        }
        else
        {   
            $result=$this->model->registreren();
            switch($result)
            {
                case REQUEST_SUCCESS:
                     $this->view->set("boodschap","U bent successvol geregistreerd!");                     
                     $this->forward("default");
                     break;
                case REQUEST_FAILURE_DATA_INVALID:
                     $this->view->set('form_data',$_POST);
                     $this->view->set("boodschap","emailadres niet correct of gebruikersnaam bestaat al"); 
                     break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                     $this->view->set('form_data',$_POST);
                     $this->view->set("boodschap","Niet alle gegevens ingevuld");
                     break;
            }
        }    
    }
    protected function aanbodAction()
    {
    }
    protected function defaultAction()
    {
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Vul uw gegevens in");
        }
        else
        {   
            $resultInlog=$this->model->controleerInloggen();
            switch($resultInlog)
            {
                case REQUEST_SUCCESS:
                     $this->view->set("boodschap","Welkom op de beheers applicatie. Veel werkplezier");
                     $recht = $this->model->getGebruiker()->getRole();
                     $this->forward("default", $recht);
                     break;
                case REQUEST_FAILURE_DATA_INVALID:
                     $this->view->set("boodschap","Gegevens kloppen niet. Probeer opnieuw."); 
                     break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                     $this->view->set("boodschap","niet alle gegevens ingevuld");
                     break;
            }
        }
    }
    
    protected function afdelingAction()
    {
       $directeur = $this->model->getDirecteur();
       $this->view->set("directeur",$directeur);
       
       $afdelingen=$this->model->getAfdelingen();
       $this->view->set("afdelingen",$afdelingen);
       
       $contacten = $this->model->getContacten();
       if($contacten===REQUEST_FAILURE_DATA_INCOMPLETE || $contacten===REQUEST_FAILURE_DATA_INVALID)
       {          
               $this->view->set("boodschap","opvragen contacten is niet gelukt!");
               $this->forward("default", "bezoeker");
       }
       $this->view->set("contacten",$contacten);
              
       $team = $this->model->getAfdeling();
       if($team===REQUEST_FAILURE_DATA_INCOMPLETE || $team===REQUEST_FAILURE_DATA_INVALID)
       {          
               $this->view->set("boodschap","opvragen afdeling is niet gelukt!");
               $this->forward("default", "bezoeker");
       }
       $this->view->set("team",$team);              
    }
    
    protected function detailsAction()
    {
        $directeur = $this->model->getDirecteur();
        $this->view->set("directeur",$directeur);
        $afdelingen=$this->model->getAfdelingen();
        $this->view->set("afdelingen",$afdelingen);
        $contact = $this->model->getContact();
        if($contact===REQUEST_FAILURE_DATA_INCOMPLETE || $contact===REQUEST_FAILURE_DATA_INVALID)
        {          
               $this->view->set("boodschap","opvragen persoon is niet gelukt!");
               $this->forward("default", "bezoeker");
        }
        $this->view->set("contact",$contact);
    }
    
    protected function directeurAction()
    {
        inloggenAction();
        $afdelingen=$this->model->getAfdelingen();
        $this->view->set("afdelingen",$afdelingen);
        $directeur = $this->model->getDirecteur();
        $this->view->set("directeur",$directeur);
        $this->view->set("contact",$directeur);
    }
    
    protected function inloggenAction()
    {
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Vul uw gegevens in");
        }
        else
        {   
            $resultInlog=$this->model->controleerInloggen();
            switch($resultInlog)
            {
                case REQUEST_SUCCESS:
                     $this->view->set("boodschap","Welkom op de beheers applicatie. Veel werkplezier");
                     $recht = $this->model->getGebruiker()->getRole();
                     $this->forward("default", $recht);
                     break;
                case REQUEST_FAILURE_DATA_INVALID:
                     $this->view->set("boodschap","Gegevens kloppen niet. Probeer opnieuw."); 
                     break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                     $this->view->set("boodschap","niet alle gegevens ingevuld");
                     break;
            }
        }
    }
}
