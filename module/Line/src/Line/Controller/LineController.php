<?php
namespace Line\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Line\Model\Line;   
use Line\Form\LineForm;
use Doctrine\ORM\EntityManager;

class LineController extends AbstractActionController
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
            'lines' => $this->getEntityManager()->getRepository('Line\Entity\Line')->findAll(),
        ));
     }

     public function addAction()
     {
     	$form = new LineForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $line = new Line();
            $form->setInputFilter($line->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $line->exchangeArray($form->getData());
                $this->getEntityManager()->persist($line);
                $this->getEntityManager()->flush();

                // Redirect to list of lines
                return $this->redirect()->toRoute('line');
            }
        }
        return array('form' => $form);
     }

     public function editAction()
     {
     	 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('line', array(
                 'action' => 'add'
             ));
         }

         $line = $this->getEntityManager()->find('Line\Entity\Line', $id);
         if (!$line) {
            return $this->redirect()->toRoute('line', array(
                'action' => 'index'
            ));
         }
		 
         $form  = new LineForm();
         $form->bind($line);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($line->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getEntityManager()->flush();
				 
                 // Redirect to list of lines
                 return $this->redirect()->toRoute('line');
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
             return $this->redirect()->toRoute('line');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $line = $this->getEntityManager()->find('Line\Entity\Line', $id);
                 if ($line) {
                    $this->getEntityManager()->remove($line);
                    $this->getEntityManager()->flush();
                 }
             }

             // Redirect to list of bus stops
             return $this->redirect()->toRoute('line');
         }

         return array(
             'id'    => $id,
             'line' => $this->getEntityManager()->find('Line\Entity\Line', $id)
         );
     }
 }