<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

class MedewerkerController extends \ao\php\framework\controls\AbstractController
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
    
    protected function anwAction()
    {   
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier je  gegevens");
        }
        else
        {
            $result = $this->model->wijzigAnw();
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
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
    }
    //TODO....
    
    protected function fotoAction(){
        
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier je foto");
        }
        else{
            $afbeeldingInfo = FOTO::isAfbeeldingGestuurd();
            switch($afbeeldingInfo)
            {
                case IMAGE_NOTHING_UPLOADED:
                    $this->view->set("boodschap","er is helemaal geen upload gedaan!!");
                    break;
                case IMAGE_FAILURE_SIZE_EXCEEDED:
                    $this->view->set("boodschap","het door juow ge-uploade bestand is te groot!!");
                    break;
                case IMAGE_FAILURE_TYPE:
                    $this->view->set("boodschap","het door jou geuploade bestand is geen afbeelding (jpg, png, gif)!!");
                    break;
                case IMAGE_SUCCES:
                    $result = $this->model->wijzigFoto();
                    switch($result)
                    {
                        case REQUEST_NOTHING_CHANGED:
                        case IMAGE_FAILURE_SAVE_FAILED:
                            $this->view->set('boodschap','er is een serverfout, de afbeelding kan niet opgeslagen worden.');
                            break;
                        case REQUEST_SUCCESS:
                            $this->view->set('boodschap','de foto is succesvol gewijzigd');
                    }
                    break;
            }
        }
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
    }
}
