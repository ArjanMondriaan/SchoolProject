<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

class LidController extends \ao\php\framework\controls\AbstractController
{
    
    public function __construct($control,$action)
    {
        parent::__construct($control, $action);
    }
    
    /**
    * execute vertaalt de action variable dynamisch naar een handler van de specifieke controller.
    * als de handler niet bestaat wordt de default als action ingesteld en
    * wordt de taak overgedragen aan de defaultAction handler. defaultAction bestaat altijd wel
    */
    
    protected function uitloggenAction()
    {
        $this->model->uitloggen();
        $this->forward('default','bezoeker');
    }
 
    protected function defaultAction()
    {
       $gebruiker = $this->model->getGebruiker();
       $this->view->set("gebruiker",$gebruiker);
    }
    
    protected function gegevensWijzigenAction(){
       
       
       if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier je  gegevens");
        }
        else
        {
            $result = $this->model->wijzigGegevens();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging gelukt');
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","De gegevens waren incompleet. Vul compleet in!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gebruikersnaam is al in gebruik, kies een andere waarde.");
                    break;
            }   
        }
        
        $gegevens = $this->model->getGegevens();
        $this->view->set("gegevens",$gegevens);
    }
    
    protected function inschrijvenAction(){
        $activiteiten = $this->model->getAlleActiviteiten();
        $this->view->set("activiteiten",$activiteiten);
    }
}