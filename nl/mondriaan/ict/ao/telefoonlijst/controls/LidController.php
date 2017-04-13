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
        $beschikbareLessen = $this->model->getBeschikbareLessen();
        $this->view->set("beschikbareLessen",$beschikbareLessen);
        
        $ingeschrevenLessen = $this->model->getIngeschrevenLessen();
        $this->view->set("ingeschrevenLessen",$ingeschrevenLessen);
        
        $aantalDeelnemers = $this->model->getAantalDeelnemers();
        $this->view->set("aantalDeelnemers",$aantalDeelnemers);
    }
    
    protected function addDeelnameAction()
    {
        $result=$this->model->addDeelname();
            switch($result)
            {
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set('boodschap','geen toe te voegen activiteit gegeven, dus niets toegevoegd');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set('boodschap','activiteit bestaat niet');
                break;
            case REQUEST_SUCCESS:
                $this->view->set("boodschap", "activiteit is toegevoegd."); 
                
                break;  
            }  
            $this->forward("inschrijven");
    }
    
    protected function deleteDeelnameAction()
    {
        $result = $this->model->deleteDeelnameActiviteit();
      switch($result)
      {
          case REQUEST_FAILURE_DATA_INCOMPLETE:
              $this->view->set('boodschap','geen te verwijderen activiteit gegeven, dus niets verwijderd');
              break;
          case REQUEST_FAILURE_DATA_INVALID:
              $this->view->set('boodschap','te verwijderen activiteit bestaat niet');
              break;
          case REQUEST_NOTHING_CHANGED:
               $this->view->set('boodschap',' niets verwijderd reden onbekend.');
              break;
          case REQUEST_SUCCESS:
              $this->view->set('boodschap','activiteit verwijderd.');
              break;
      }
      
      $this->forward('inschrijven');
      
    }
}
