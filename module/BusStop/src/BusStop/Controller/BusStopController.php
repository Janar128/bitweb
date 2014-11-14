<?php
namespace BusStop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BusStop\Model\BusStop;   
use BusStop\Form\BusStopForm;
use Doctrine\ORM\EntityManager;

class BusStopController extends AbstractActionController
{
	 protected $em;
	 
	 public function getEntityManager()
	 {
	    if (null === $this->em) {
	        $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    }
	    return $this->em;
	 }
	 
     public function indexAction()
     {
     	return new ViewModel(array(
            'busstops' => $this->getEntityManager()->getRepository('BusStop\Entity\BusStop')->findAll(),
        ));
     }

     public function addAction()
     {
     	$form = new BusStopForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $busstop = new BusStop();
            $form->setInputFilter($busstop->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $busstop->exchangeArray($form->getData());
                $this->getEntityManager()->persist($busstop);
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('busstop');
            }
        }
        return array('form' => $form);
     }

     public function editAction()
     {
     	 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('busstop', array(
                 'action' => 'add'
             ));
         }

         $busstop = $this->getEntityManager()->find('BusStop\Entity\BusStop', $id);
         if (!$busstop) {
            return $this->redirect()->toRoute('busstop', array(
                'action' => 'index'
            ));
         }
		 
         $form  = new BusStopForm();
         $form->bind($busstop);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($busstop->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getEntityManager()->flush();
				 
                 // Redirect to list of albums
                 return $this->redirect()->toRoute('busstop');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     public function deleteAction()
     {
     	 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('busstop');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $busstop = $this->getEntityManager()->find('BusStop\Entity\BusStop', $id);
                 if ($busstop) {
                    $this->getEntityManager()->remove($busstop);
                    $this->getEntityManager()->flush();
                 }
             }

             // Redirect to list of bus stops
             return $this->redirect()->toRoute('busstop');
         }

         return array(
             'id'    => $id,
             'busstop' => $this->getEntityManager()->find('BusStop\Entity\BusStop', $id)
         );
     }
 }