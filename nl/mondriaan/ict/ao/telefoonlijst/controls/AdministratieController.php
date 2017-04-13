<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;
    use nl\mondriaan\ict\ao\telefoonlijst\utils\Foto as FOTO;
    
class AdministratieController extends \ao\php\framework\controls\AbstractController
{
   
    public function __construct($control,$action)
    {
        parent::__construct($control, $action);
    }

    /**
    * execute memes vertaalt de action variable dynamisch naar een handler van de specifieke controller.
    * als de handler niet bestaat wordt de default als action ingesteld en
    * wordt de taak overgedragen aan de defaultAction handler. defauktAction bestaat altijd wel
    */
    
    protected function uitloggenAction()
    {
        $this->model->uitloggen();
        $this->forward('default','bezoeker');
    }
  
    protected function defaultAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $contacten = $this->model->getContacten();
        $this->view->set('contacten', $contacten);
    }
    
    protected function beheerAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $contacten = $this->model->getContacten();
        $this->view->set('contacten', $contacten);
        $afdelingen = $this->model->getAfdelingen();
        $this->view->set('afdelingen', $afdelingen);
    }
    
    protected function addAction()
    {
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Vul gegevens in van een nieuwe medewerker");          
        }
        else
        {   
            $result=$this->model->addContact();
            switch($result)
            {
                case IMAGE_FAILURE_SIZE_EXCEEDED:
                    $this->view->set("boodschap", "Contact is niet toegevoegd. Foto te groot. Kies kleinere foto.");  
                    $this->view->set('form_data',$_POST);
                    break;
                case IMAGE_FAILURE_TYPE:
                    $this->view->set("boodschap", "Contact is niet toegevoegd. foto niet van jpg, gif of png formaat.");  
                    $this->view->set('form_data',$_POST);
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap", "Contact is niet toegevoegd. Niet alle vereiste data ingevuld.");  
                    $this->view->set('form_data',$_POST);
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap", "Contact is niet toegevoegd. Er is foutieve data ingestuurd (bv gebruikersnaam bestaat al).");  
                    $this->view->set('form_data',$_POST);
                    break;
                case REQUEST_SUCCESS:
                    $this->view->set("boodschap", "Contact is toegevoegd."); 
                    $this->forward("beheer");
                    break;  
            }  
        }
        $afdelingen = $this->model->getAfdelingen();
        $this->view->set('afdelingen',$afdelingen);
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
    }
    
    protected function deleteAction()
    {
        $result = $this->model->deleteContact();
        switch($result)
        {
            case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set('boodschap','geen te verwijderen contact gegeven, dus niets verwijderd');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set('boodschap','te verwijderen contact bestaat niet');
                break;
            case REQUEST_NOTHING_CHANGED:
                 $this->view->set('boodschap','Er is niets verwijderd reden onbekend.');
                break;
            case REQUEST_SUCCESS:
                $this->view->set('boodschap','Contact verwijderd.');
                break;
        }
        $this->forward('beheer');
    }
    
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
                            $this->forward ('default');
                    }
                    break;
            }
        }
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
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
    
    protected function wwAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier je wachtwoord");
        }
        else
        {
            $result = $this->model->wijzigWw();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging wachtwoord gelukt');
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","nieuwe wachtwoord niet identiek of oude wachtwoord fout. Poog opnieuw!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            } 
        }
    }
    
    protected function resetwwAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        
        $result = $this->model->resetWw();
        switch($result)
        {
            case REQUEST_SUCCESS:
                $this->view->set('boodschap','wijziging wachtwoord gelukt');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set("boodschap","nieuwe wachtwoord niet identiek of oude wachtwoord fout. Poog opnieuw!");
                break;
            case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set("boodschap","Niet alle velden ingevuld!");
                break;
            case REQUEST_NOTHING_CHANGED:
                $this->view->set("boodschap","Er was niets te wijzigen");
                break;
        } 
        
        $this->forward("beheer");
    }
    protected function directeurAction()
    {
        $this->model->wijzigDirecteur();
        $directeur = $this->model->GetDirecteur();
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $this->view->set('directeur',$directeur);
    }
    
    protected function updateAction()
    {
        $this->model->GetMedewerkergegevens();
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $contact = $this->model->GetMedewerker();
        $this->view->set('contact',$contact);
        $this->model->GetMedewerkergegevens();
    }
    
    protected function ledenBeheerAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
  
        $contacten = $this->model->getContacten();
        $this->view->set('contacten', $contacten);
        
    }
    
    protected function lidAanpassenAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $lid = $this->model->getPersoon();
        $this->view->set('lid',$lid);
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de lids gegevens");
        }
        else
        {
            $result = $this->model->wijzigLid();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging lid gelukt');
                    $this->forward("ledenBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gegevens niet goed ingevuld!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            }
        }
        
    }
    
    protected function lidVerwijderenAction(){
        $result = $this->model->verwijderPersoon();
        switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','Lid verwijdert');
                    $this->forward("ledenBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","Fout tijdens het verwijderen van een lid");
                    break;
            }
    }
    
    
    protected function instructeursBeheerAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
  
        $contacten = $this->model->getInstructeurs();
        $this->view->set('contacten', $contacten);
        
    }
    
    protected function instructeurAanpassenAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $lid = $this->model->getPersoon();
        $this->view->set('lid',$lid);
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de instructeurs gegevens");
        }
        else
        {
            $result = $this->model->wijzigInstructeur();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging instructeurs gelukt');
                    $this->forward("instructerBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gegevens niet goed ingevuld!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            }
        }
        
    }
    
    protected function instructeurVerwijderenAction(){
        $result = $this->model->verwijderPersoon();
        switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','Lid verwijdert');
                    $this->forward("ledenBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","Fout tijdens het verwijderen van een lid");
                    break;
            }
    }
    
    protected function instructeurToevoegenAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
         if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de lids gegevens");
        }
        else
        {
            $result = $this->model->toevoegenInstructeur();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','toevoegen instructeur gelukt');
                    $this->forward("instructerBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gegevens niet goed ingevuld!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            }
        }
    
    }
    
    protected function trainingsVormenBeheerAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
  
        $trainingsvormen = $this->model->getTrainingsvormen();
        $this->view->set('trainingsvormen', $trainingsvormen);
        
    }
    
    protected function trainingsvormAanpassenAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        $trainingsvorm = $this->model->getTrainingsvorm();
        $this->view->set('trainingsvorm',$trainingsvorm);
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de traingsvorm gegevens");
        }
        else
        {
            $result = $this->model->wijzigTrainingsvorm();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging trainingsvorm gelukt');
                    $this->forward("instructerBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gegevens niet goed ingevuld!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            }
        }
        
    }
    
    protected function trainingsvormVerwijderenAction(){
        $result = $this->model->verwijderTrainingsvorm();
        switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','training verwijdert');
                    $this->forward("ledenBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","Fout tijdens het verwijderen van een trainingsvorm");
                    break;
            }
    }
    
    protected function trainingsvormToevoegenAction(){
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
         if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de lids gegevens");
        }
        else
        {
            $result = $this->model->toevoegenTrainingsvorm();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','toevoegen instructeur gelukt');
                    $this->forward("instructerBeheer");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","gegevens niet goed ingevuld!");
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","Niet alle velden ingevuld!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
            }
        }
    
    }
    
}