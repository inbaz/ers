<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use ErsBase\Entity;
use Admin\Form;
use ErsBase\Service;
use Admin\InputFilter;

class UserController extends AbstractActionController {
    
    public function indexAction()
    {
        $forrest = new Service\BreadcrumbService();
        $forrest->set('user', 'admin/user');
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $authorize = $this->getServiceLocator()->get('BjyAuthorize\Provider\Identity\ProviderInterface');
        $roles = $authorize->getIdentityRoles();
        $roleOptions = [];
        foreach($roles as $role) {
            $roleOptions[] = $role->getRoleId();
        }
        
        return new ViewModel(array(
            'users' => $entityManager->getRepository('ErsBase\Entity\User')->findAll(),
            'roles' => $roleOptions,
         ));
    }

    private function getCountryOptions($countryId = null) {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $queryBuilder1 = $entityManager->getRepository('ErsBase\Entity\Country')->createQueryBuilder('n');
        $queryBuilder1->where($queryBuilder1->expr()->isNotNull('n.position'));
        $queryBuilder1->orderBy('n.position', 'ASC');
        $result1 = $queryBuilder1->getQuery()->getResult();
        
        $queryBuilder2 = $entityManager->getRepository('ErsBase\Entity\Country')->createQueryBuilder('n');
        $queryBuilder2->where($queryBuilder2->expr()->isNull('n.position'));
        $queryBuilder2->orderBy('n.name', 'ASC');
        $result2 = $queryBuilder2->getQuery()->getResult();

        $countries = array_merge($result1, $result2);

        $container = new Container('ers');
        $countryContainerId = $container->Country_id;
        
        $options = array();
        $selected = false;
        if($countryId == null && $countryContainerId == null) {
            $selected = true;
        }
        $options[] = array(
            'value' => 0,
            'label' => 'no Country',
            'selected' => $selected,
        );
        foreach($countries as $country) {
            $selected = false;
            if($countryContainerId == $country->getId()) {
                $selected = true;
            }
            if($countryId == $country->getId()) {
                $selected = true;
            }
            $options[] = array(
                'value' => $country->getId(),
                'label' => $country->getName(),
                'selected' => $selected,
            );
        }
        return $options;
    }
    
    public function addAction()
    {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('user')) {
            $forrest->set('user', 'admin/user');
        }
        $breadcrumb = $forrest->get('user');
        
        #$form = new Form\User();
        $form = $this->getServiceLocator()->get('Admin\Form\User');
        $form->get('submit')->setValue('Add');
        $form->get('Country_id')->setValueOptions($this->getCountryOptions());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new Entity\User();
            
            #$form->setInputFilter($user->getInputFilter());
            $inputFilter = $this->getServiceLocator()
                    ->get('Admin\InputFilter\User');
            $form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->populate($form->getData());
                
                if($user->getEmail() == '') {
                    $user->setEmail(null);
                }
                
                if($user->getCountryId() == 0) {
                    $user->setCountry(null);
                    $user->setCountryId(null);
                }
                
                $user->setActive(true);
                
                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                
                $entityManager->persist($user);
                $entityManager->flush();
                
                if(array_key_exists('q', $breadcrumb->options['query'])) {
                    $breadcrumb->options['query']['q'] = $user->getEmail();
                }

                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            } 
            $logger = $this->getServiceLocator()->get('Logger');
            $logger->warn($form->getMessages());
        }
        
        return new ViewModel(array(
            'form' => $form,                
        ));
    }

    public function editAction()
    {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('user')) {
            $forrest->set('user', 'admin/user');
        }
        $breadcrumb = $forrest->get('user');
        
        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute('admin/user', array(
                'action' => 'add'
            ));
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $user = $entityManager->getRepository('ErsBase\Entity\User')->findOneBy(array('id' => $userId));
        
        $form = new Form\User($this->getServiceLocator());
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('Country_id')->setValueOptions($this->getCountryOptions());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user = $form->getData();
                if($user->getEmail() == '') {
                    $user->setEmail(NULL);
                }
                if($user->getCountryId() == 0) {
                    $user->setCountry(null);
                    $user->setCountryId(null);
                }
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
            $logger = $this->getServiceLocator()->get('Logger');
            $logger->warn($form->getMessages());
        }

        return new ViewModel(array(
            'id' => $userId,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ));
    }

    public function deleteAction()
    {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('user')) {
            $forrest->set('user', 'admin/user');
        }
        $breadcrumb = $forrest->get('user');
        
        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $user = $entityManager->getRepository('ErsBase\Entity\User')
                ->findOneBy(array('id' => $userId));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $userId = (int) $request->getPost('id');
                $user = $entityManager->getRepository('ErsBase\Entity\User')
                    ->findOneBy(array('id' => $userId));
                $entityManager->remove($user);
                $entityManager->flush();
            }

            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            #return $this->redirect()->toRoute('admin/user');
        }

        return new ViewModel(array(
            'id'    => $userId,
            'user' => $user,
            'breadcrumb' => $breadcrumb,
        ));
    }
    
    public function roleAction() {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('user')) {
            $forrest->set('user', 'admin/user');
        }
        $breadcrumb = $forrest->get('user');
        
        $userId = (int) $this->params()->fromRoute('id', 0);
        if (!$userId) {
            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $user = $entityManager->getRepository('ErsBase\Entity\User')
                ->findOneBy(array('id' => $userId));
        
        return new ViewModel(array(
            'user' => $user,
            'roles' => $user->getRoles(),
            'breadcrumb' => $breadcrumb,
        ));
    }
    public function addRoleAction() {
        return new ViewModel(array(
            
        ));
    }
    public function deleteRoleAction() {
        $userId = (int) $this->params()->fromRoute('id', 0);
        /*if (!$userId) {
            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }*/
        $role_id = (int) $this->params()->fromQuery('role_id', 0);
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $user = $entityManager->getRepository('ErsBase\Entity\User')
                ->findOneBy(array('id' => $userId));
        $role = $entityManager->getRepository('ErsBase\Entity\Role')
                ->findOneBy(array('id' => $role_id));
        
        return new ViewModel(array(
            'user' => $user,
            'role' => $role,
        ));
    }
}