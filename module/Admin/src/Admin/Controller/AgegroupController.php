<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ErsBase\Entity;
use Admin\Form;

class AgegroupController extends AbstractActionController {
    
    public function indexAction()
    {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        return new ViewModel(array(
            'agegroups' => $em->getRepository('ErsBase\Entity\Agegroup')
                ->findBy(array(), array('agegroup' => 'ASC')),
         ));
    }

    public function addAction()
    {
        $agegroup = new Entity\Agegroup();
        $config = $this->getServiceLocator()
                ->get('Config');
        $agegroup->setAgegroup($config['ERS']['start']->modify('-8 years'));
        
        $form = new Form\Agegroup();
        $form->bind($agegroup);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            #$agegroup = new Entity\Agegroup();
            
            #$form->setInputFilter($agegroup->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                #$agegroup->populate($form->getData());
                $agegroup = $form->getData();
                
                $em = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                
                $em->persist($agegroup);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('The agegroup '.$agegroup->getName().' has been successfully added');
                return $this->redirect()->toRoute('admin/agegroup');
            } else {
                $this->flashMessenger()->addErrorMessage($form->getMessages());
                $logger = $this->getServiceLocator()->get('Logger');
                $logger->warn($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form,                
        ));
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->flashMessenger()->addErrorMessage('Unable to edit agegroup, id is missing.');
            return $this->redirect()->toRoute('admin/agegroup', array(
                'action' => 'add'
            ));
        }
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $agegroup = $em->getRepository('ErsBase\Entity\Agegroup')
                ->findOneBy(array('id' => $id));

        $form = new Form\Agegroup();
        $form->bind($agegroup);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('The agegroup has been successfully changed.');
                return $this->redirect()->toRoute('admin/agegroup');
            } else {
                $this->flashMessenger()->addErrorMessage($form->getMessages());
            }
        }

        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/agegroup');
        }
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $agegroup = $em->getRepository('ErsBase\Entity\Agegroup')
                ->findOneBy(array('id' => $id));
        $productprices = $agegroup->getProductPrices();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $agegroup = $em->getRepository('ErsBase\Entity\Agegroup')
                    ->findOneBy(array('id' => $id));
                foreach($agegroup->getProductPrices() as $price) {
                    $em->remove($price);
                }
                $em->remove($agegroup);
                $em->flush();
                
                $this->flashMessenger()->addSuccessMessage('The agegroup has been successfully deleted.');
            }

            return $this->redirect()->toRoute('admin/agegroup');
        }

        return new ViewModel(array(
            'id'    => $id,
            'agegroup' => $agegroup,
            'productprices' => $productprices,
        ));
    }
}