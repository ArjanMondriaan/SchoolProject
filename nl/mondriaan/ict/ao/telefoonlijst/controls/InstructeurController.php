<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;


    class InstructeurController extends \ao\php\framework\controls\AbstractController
    {
        public function __construct($control,$action)
        {
            parent::__construct($control, $action);
        }
        
        protected function defaultAction()
        {
            
        }
        
        protected function deelnemerAction(){
            
           $alleLessen = $this->model->getAlleLessen();
           $this->view->set('$alleLessen',$$alleLessen);
        }
        
        protected function trainingenAction()
        {
            $trainingen=$this->model->getSoortenTraining();        
            $this->view->set('trainingen',$trainingen);
        }
        protected function editTrainingAction() {
            if($this->model->isPostLeeg())
            {
               $this->view->set("boodschap","Wijzig hier de cursus gegevens");
            }
            else
            {
                $result = $this->model->wijzigSoortTraining();
                switch($result)
                {
                    case REQUEST_SUCCESS:
                        $this->view->set('boodschap','wijziging gelukt');
                        header("location: ?control=Instructeur&action=trainingen");
                        break;
                    case REQUEST_FAILURE_DATA_INCOMPLETE:
                        $this->view->set("boodschap","De gegevens waren incompleet. Vul compleet in!");
                        break;
                    case REQUEST_NOTHING_CHANGED:
                        $this->view->set("boodschap","Er was niets te wijzigen");
                        break;
                    case REQUEST_FAILURE_DATA_INVALID:
                        $this->view->set("boodschap","Vul een correcte datum/tijd in.");
                        break;
                }
            }
            $TrainingInfo = $this->model->editSoortTraining();
            $this->view->set('TrainingInfo',$TrainingInfo);
        }
        protected function addTrainingAction()
        {
            if($this->model->isPostLeeg())
            {
               $this->view->set("boodschap","Vul gegevens in van de nieuwe cursus");          
            }
            else
            {   
                $result=$this->model->AddSoortTraining();
                switch($result)
                {

                    case REQUEST_FAILURE_DATA_INCOMPLETE:
                        $this->view->set("boodschap", "activiteit is niet toegevoegd. Niet alle vereiste data ingevuld.");  
                        break;
                    case REQUEST_FAILURE_DATA_INVALID:
                        $this->view->set("boodschap", "activiteit is niet toegevoegd. Er is foutieve data ingestuurd.");  
                        break;
                    case REQUEST_SUCCESS:
                        $this->view->set("boodschap", "activiteit is toegevoegd."); 
                        break;  
                }  
            }
        }
        protected function deleteTrainingAction()
        {
            $result = $this->model->DeleteSoortTraining();
            switch($result)
            {
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set('boodschap','geen te verwijderen cursus gegeven, dus niets verwijderd');
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set('boodschap','te verwijderen cursus bestaat niet');
                    break;
                case REQUEST_NOTHING_CHANGED:
                     $this->view->set('boodschap','te verwijderen cursus bestaat niet.');
                    break;
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','Cursus verwijderd.');
                    break;
            }
            header("location: ?control=Instructeur&action=trainingen");
        }
        
    protected function uitloggenAction()
    {
        $this->model->uitloggen();
        $this->forward('default','bezoeker');
    }
}
