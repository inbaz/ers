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

class CurrencyController extends AbstractActionController {
    
    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        return new ViewModel(array(
            'currencys' => $entityManager->getRepository('ErsBase\Entity\Currency')
                ->findBy(array(), array('position' => 'ASC')),
        ));
    }

    public function addAction()
    {
        $form = new Form\Currency();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $currency = new Entity\Currency();
            
            #$form->setInputFilter($currency->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $currency->populate($form->getData());
                
                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                
                $entityManager->persist($currency);
                $entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Currency has been successfully added.');
                return $this->redirect()->toRoute('admin/currency');
            } else {
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
            return $this->redirect()->toRoute('admin/currency', array(
                'action' => 'add'
            ));
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $currency = $entityManager->getRepository('ErsBase\Entity\Currency')->findOneBy(array('id' => $id));

        $form = new Form\Currency();
        $form->bind($currency);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            #$form->setInputFilter($currency->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $entityManager->persist($form->getData());
                $entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Currency has been successfully changed.');
                return $this->redirect()->toRoute('admin/currency');
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
            return $this->redirect()->toRoute('admin/currency');
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $currency = $entityManager->getRepository('ErsBase\Entity\Currency')
                ->findOneBy(array('id' => $id));
        $productprices = $currency->getProductPrices();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $currency = $entityManager->getRepository('ErsBase\Entity\Currency')
                    ->findOneBy(array('id' => $id));
                
                foreach($currency->getProductPrices() as $productPrice) {
                    $entityManager->remove($productPrice);
                }
                
                $entityManager->remove($currency);
                $entityManager->flush();
            }

            $this->flashMessenger()->addSuccessMessage('Currency has been successfully deleted.');
            return $this->redirect()->toRoute('admin/currency');
        }

        return new ViewModel(array(
            'id'    => $id,
            'currency' => $currency,
            'productprices' => $productprices,
        ));
    }
}