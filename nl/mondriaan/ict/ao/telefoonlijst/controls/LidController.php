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
       $gegevens = $this->model->getGegevens();
       $this->view->set("gegevens",$gegevens);
    }
}