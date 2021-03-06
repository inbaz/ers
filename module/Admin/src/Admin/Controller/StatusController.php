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
use ErsBase\Service;

class StatusController extends AbstractActionController {
    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        return new ViewModel(array(
            'status' => $entityManager->getRepository('ErsBase\Entity\Status')->findBy(array(), array('position' => 'ASC')),
        ));
    }

    public function addAction() {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('status')) {
            $forrest->set('status', 'admin/status');
        }
        $breadcrumb = $forrest->get('status');
        
        $form = new Form\Status();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $entity = new Entity\Status();
            #$form->setInputFilter($entity->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $entity->populate($form->getData());

                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                $entityManager->persist($entity);
                $entityManager->flush();

                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        return new ViewModel(array(
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ));
    }
    public function editAction() {
        $forrest = new Service\BreadcrumbService();
        $breadcrumb = $forrest->get('status');
        if(!$forrest->exists('status')) {
            $forrest->set('status', 'admin/status');
        }
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/status', array(
                'action' => 'add'
            ));
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $status = $entityManager->getRepository('ErsBase\Entity\Status')->findOneBy(array('id' => $id));

        $form  = new Form\Status();
        $form->bind($status);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                #$entityManager->persist($form->getData());
                $entityManager->persist($status);
                $entityManager->flush();

                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }

        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ));
    }
    public function deleteAction() {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('status')) {
            $forrest->set('status', 'admin/status');
        }
        $breadcrumb = $forrest->get('status');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                
                $id = (int) $request->getPost('id');
                $status = $entityManager->getRepository('ErsBase\Entity\Status')
                        ->findOneBy(array('id' => $id));
                $entityManager->remove($status);
                $entityManager->flush();
            }

            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }

        return new ViewModel(array(
            'id'    => $id,
            'status' => $status = $entityManager->getRepository('ErsBase\Entity\Status')
                ->findOneBy(array('id' => $id)),
            'breadcrumb' => $breadcrumb,
        ));
    }
}