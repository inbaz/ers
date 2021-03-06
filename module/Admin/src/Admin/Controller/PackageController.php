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
use ErsBase\Service;
use Admin\Form;

class PackageController extends AbstractActionController {
    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        return new ViewModel(array(
            'agegroups' => $entityManager->getRepository('ErsBase\Entity\Agegroup')
                ->findBy(array(), array('agegroup' => 'ASC')),
        ));
    }
    
    public function detailAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/package', array('action' => 'detail', 'id' => $packageId));
        }
        $forrest->set('item', 'admin/package', array('action' => 'detail', 'id' => $packageId));
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        return new ViewModel(array(
            'package' => $package,
        ));
    }
    
    public function unpaidAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $statusOrdered = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'ordered'));
                
                foreach($package->getItems() as $item) {
                    $item->setStatus($statusOrdered);
                    $entityManager->persist($item);
                }
                
                $entityManager->flush();
                
                $breadcrumb = $forrest->get('package');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function paidAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $statusPaid = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'paid'));
                
                $statusService = $this->getServiceLocator()
                        ->get('ErsBase\Service\StatusService');
                $statusService->setPackageStatus($package, $statusPaid, false);
                
                $entityManager->flush();
                
                $breadcrumb = $forrest->get('package');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function refundAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $statusRefund = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'refund'));
                
                foreach($package->getItems() as $item) {
                    $item->setStatus($statusRefund);
                    $entityManager->persist($item);
                }
                
                $entityManager->flush();
                
                $breadcrumb = $forrest->get('package');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function cancelAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $statusCancelled = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'cancelled'));
                
                foreach($package->getItems() as $item) {
                    $item->setStatus($statusCancelled);
                    $entityManager->persist($item);
                }
                
                $entityManager->flush();
                
                $breadcrumb = $forrest->get('package');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function recalculateAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        /*
         * get participant
         */
        $participant = $package->getParticipant();
        
        /*
         * get agegroup
         */
        $agegroupService = $this->getServiceLocator()
            ->get('ErsBase\Service\AgegroupService:price');
        $agegroup = $agegroupService->getAgegroupByDate($participant->getBirthday());
        
        /*
         * get orders deadline
         */
        $order = $package->getOrder();
        
        $deadlineService = $this->getServiceLocator()
                ->get('ErsBase\Service\DeadlineService:price');
        /*$deadlineService = new \ErsBase\Service\DeadlineService();
        $deadlines = $entityManager->getRepository('ErsBase\Entity\Deadline')
                    ->findBy(array('price_change' => '1'));
        $deadlineService->setDeadlines($deadlines);*/

        $deadlineService->setCompareDate($order->getCreated());
        $deadline = $deadlineService->getDeadline();
        
        $orderService = $this->getServiceLocator()
                ->get('ErsBase\Service\OrderService');
        #$itemArray = $this->recalcPackage($package, $agegroup, $deadline);
        $itemArray = $orderService->recalcPackage($package, $agegroup, $deadline);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $statusCancelled = $entityManager->getRepository('ErsBase\Entity\Status')
                                ->findOneBy(array('value' => 'cancelled'));
                
                #$itemArray = $this->recalcPackage($package, $agegroup, $deadline);
                $itemArray = $orderService->recalcPackage($package, $agegroup, $deadline);
                foreach($itemArray as $items) {
                    if(isset($items['after'])) {
                        $itemAfter = $items['after'];
                        $itemBefore = $items['before'];
                        
                        #$itemAfter->setStatus($itemBefore->getStatus());
                        
                        $entityManager->persist($itemAfter);
                        
                        $order = $itemAfter->getPackage()->getOrder();
                        if($order->getPaymentStatus() == 'paid') {
                            $order->setPaymentStatus('unpaid');
                        }
                        $order->setOrderSum($order->getPrice());
                        $order->setTotalSum($order->getSum());
                        $entityManager->persist($order);
        
                        $itemBefore->setStatus($statusCancelled);
                        $entityManager->persist($itemBefore);

                        $entityManager->flush();
                    }
                }
                
                $breadcrumb = $forrest->get('package');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'itemArray' => $itemArray,
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function downloadEticketAction() {
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        /*$languages = array(
            array(
                'label' => 'English',
                'value' => 'en',
            ),
            array(
                'label' => 'German',
                'value' => 'de',
            ),
            array(
                'label' => 'Italian',
                'value' => 'it',
            ),
            array(
                'label' => 'Spanish',
                'value' => 'es',
            ),
            array(
                'label' => 'French',
                'value' => 'fr',
            ),
        );*/
        
        $form = new Form\DownloadEticket();
        /*$form->get('language')->setValueOptions($languages);*/
        $form->get('submit')->setValue('Download');
        $form->get('id')->setValue($package->getId());
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            #$form->setInputFilter($agegroup->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $eticketService = $this->getServiceLocator()
                    ->get('ErsBase\Service\ETicketService');
                
                #$eticketService->setLanguage($request->getPost('language'));
                $eticketService->setPackage($package);
                $file = $eticketService->generatePdf();

                $response = new \Zend\Http\Response\Stream();
                $response->setStream(fopen($file, 'r'));
                $response->setStatusCode(200);
                $response->setStreamName(basename($file));
                $headers = new \Zend\Http\Headers();
                $headers->addHeaders(array(
                    'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
                    'Content-Type' => 'application/octet-stream',
                    'Content-Length' => filesize($file),
                    'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
                    'Cache-Control' => 'must-revalidate',
                    'Pragma' => 'public'
                ));
                $response->setHeaders($headers);
                return $response;
            } else {
                $logger = $this->getServiceLocator()->get('Logger');
                $logger->warn($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function sendEticketAction() {
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order');
        }
        
        $logger = $this->getServiceLocator()->get('Logger');
        
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            $breadcrumb = $forrest->get('package');
            return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $packageId = (int) $request->getPost('id');
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $packageId));
                
                $validStatus = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findBy(array('valid' => 1));
                $validArray = array_filter($validStatus, function($status) {return $status->getValid();});
                
                #if($package->getStatus() != 'paid') {
                if(!in_array($package->getStatus(), $validArray)) {
                    return $this->redirect()->toRoute('admin/package', array('action' => 'send-eticket'));
                }
                

                $packageService = $this->getServiceLocator()
                        ->get('ErsBase\Service\PackageService');
                $packageService->setPackage($package);
                $packageService->sendEticket();
                
                $breadcrumb = $forrest->get('order');
                $this->flashMessenger()->addSuccessMessage('E-tickets for package '.$package->getCode()->getValue().' has been send out.');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function changeParticipantAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $form = new Form\SearchPackage();
        
        $results = [];
        
        $q = trim($this->params()->fromQuery('q'));

        if (!empty($q)) {
            $form->get('q')->setValue($q);

            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

            $queryBuilder = $entityManager->createQueryBuilder()
                    ->select('u')
                    ->from('ErsBase\Entity\User', 'u')
                    ->orderBy('u.firstname')
                    ->where('1=1');
            
            /*$queryBuilder = $entityManager->createQueryBuilder()
                    ->select('p')
                    ->from('ErsBase\Entity\Package', 'p')
                    ->join('p.participant', 'u')
                    ->join('p.code', 'pcode')
                    ->join('p.order', 'o')
                    ->join('o.code', 'ocode')
                    ->join('o.buyer', 'b')
                    ->orderBy('u.firstname')
                    ->where('1=1');*/

            if (preg_match('~^\d+$~', $q)) {
                // if the entire query consists of nothing but a number, treat it as a user ID
                $queryBuilder->andWhere('u.id = :id');
                $queryBuilder->setParameter(':id', (int) $q);
            } else {
                $exprUName = $queryBuilder->expr()->concat('u.firstname', $queryBuilder->expr()->concat($queryBuilder->expr()->literal(' '), 'u.surname'));
                //$exprBName = $queryBuilder->expr()->concat('b.firstname', $queryBuilder->expr()->concat($queryBuilder->expr()->literal(' '), 'b.surname'));

                $words = preg_split('~\s+~', $q);
                $i = 0;
                foreach ($words as $word) {
                    try {
                        $wordAsDate = new \DateTime($word);
                    } catch (\Exception $ex) {
                        $wordAsDate = NULL;
                    }

                    $param = ':p' . $i;
                    $paramDate = ':pd' . $i;
                    $queryBuilder->andWhere(
                            $queryBuilder->expr()->orX(
                                    $queryBuilder->expr()->like($exprUName, $param), //
                                    $queryBuilder->expr()->like('u.email', $param), //
                                    //$queryBuilder->expr()->like($exprBName, $param),
                                    #$queryBuilder->expr()->like('pcode.value', $param), //
                                    #$queryBuilder->expr()->like('ocode.value', $param), //
                                    ($wordAsDate ? $queryBuilder->expr()->eq('u.birthday', $paramDate) : '1=0')
                            )
                    );

                    $queryBuilder->setParameter($param, '%' . $word . '%');
                    if($wordAsDate)
                        $queryBuilder->setParameter($paramDate, $wordAsDate);

                    $i++;
                }
            }

            $results = $queryBuilder->getQuery()->getResult();
        }
        
        $forrest = new Service\BreadcrumbService();
        $query = array('q' => $q);
        $forrest->set('package', 'admin/package', 
                array(
                    'action' => 'change-participant',
                    'id' => $package->getId()
                ), 
                array(
                    'query' => $query,
                    #'fragment' => $fragment,
                )
            );
        
        return new ViewModel(array(
            'form' => $form,
            'package' => $package,
            'results' => $results,
        ));
    }
    public function acceptParticipantChangeAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $user_id = (int) $this->params()->fromQuery('user_id', 0);
        $package_id = (int) $this->params()->fromQuery('package_id', 0);
        
        $form = new Form\AcceptParticipantChangePackage();
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $inputFilter = $this->getServiceLocator()
                    ->get('Admin\InputFilter\AcceptParticipantChangePackage');
            #$form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $user = $entityManager->getRepository('ErsBase\Entity\User')
                    ->findOneBy(array('id' => $data['user_id']));
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $data['package_id']));
                
                $log = new Entity\Log();
                $log->setUser($this->zfcUserAuthentication()->getIdentity());
                $log->setData('changed participant for package '.$package->getCode()->getValue().': '.$data['comment']);
                $entityManager->persist($log);
                
                # initialize new package
                $cloneService = $this->getServiceLocator()
                    ->get('ErsBase\Service\CloneService');
                $cloneService->setTransfer(true);
                $newPackage = $cloneService->clonePackage($package);
                
                # set order for package
                $newPackage->setOrder($package->getOrder());
                
                #$package->setTransferredPackage($newPackage);
                $newPackage->setParticipant($user);
                
                
                $entityManager->persist($newPackage);
                #$entityManager->persist($package);
                $entityManager->flush();
                
                $order = $package->getOrder();
                
                return $this->redirect()->toRoute('admin/order', array(
                    'action' => 'detail', 
                    'id' => $order->getId()
                ));
            } else {
                $logger->warn($form->getMessages());
            }
        }
        
        $user = null;
        if($user_id != 0) {
            $user = $entityManager->getRepository('ErsBase\Entity\User')
                    ->findOneBy(array('id' => $user_id));
        }
        
        $package = null;
        if($package_id != 0) {
            $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $package_id));
        }
        
        $form->get('package_id')->setValue($package->getId());
        $form->get('user_id')->setValue($user->getId());
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order', 
                    array('action' => 'search')
                );
        }
        
        return new ViewModel(array(
            'form' => $form,
            'user' => $user,
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function moveAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $packageId = (int) $this->params()->fromRoute('id', 0);
        if (!$packageId) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $packageId));
        
        $form = new Form\SearchOrder();
        
        $results = [];
        
        $q = trim($this->params()->fromQuery('q'));

        if (!empty($q)) {
            $form->get('q')->setValue($q);

            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

            $queryBuilder = $entityManager->createQueryBuilder()
                    ->select('u')
                    ->from('ErsBase\Entity\User', 'u')
                    ->orderBy('u.firstname')
                    ->where('1=1');
            
            /*$queryBuilder = $entityManager->createQueryBuilder()
                    ->select('p')
                    ->from('ErsBase\Entity\Package', 'p')
                    ->join('p.participant', 'u')
                    ->join('p.code', 'pcode')
                    ->join('p.order', 'o')
                    ->join('o.code', 'ocode')
                    ->join('o.buyer', 'b')
                    ->orderBy('u.firstname')
                    ->where('1=1');*/

            if (preg_match('~^\d+$~', $q)) {
                // if the entire query consists of nothing but a number, treat it as a user ID
                $queryBuilder->andWhere('u.id = :id');
                $queryBuilder->setParameter(':id', (int) $q);
            } else {
                $exprUName = $queryBuilder->expr()->concat('u.firstname', $queryBuilder->expr()->concat($queryBuilder->expr()->literal(' '), 'u.surname'));
                //$exprBName = $queryBuilder->expr()->concat('b.firstname', $queryBuilder->expr()->concat($queryBuilder->expr()->literal(' '), 'b.surname'));

                $words = preg_split('~\s+~', $q);
                $i = 0;
                foreach ($words as $word) {
                    try {
                        $wordAsDate = new \DateTime($word);
                    } catch (\Exception $ex) {
                        $wordAsDate = NULL;
                    }

                    $param = ':p' . $i;
                    $paramDate = ':pd' . $i;
                    $queryBuilder->andWhere(
                            $queryBuilder->expr()->orX(
                                    $queryBuilder->expr()->like($exprUName, $param), //
                                    $queryBuilder->expr()->like('u.email', $param), //
                                    //$queryBuilder->expr()->like($exprBName, $param),
                                    #$queryBuilder->expr()->like('pcode.value', $param), //
                                    #$queryBuilder->expr()->like('ocode.value', $param), //
                                    ($wordAsDate ? $queryBuilder->expr()->eq('u.birthday', $paramDate) : '1=0')
                            )
                    );

                    $queryBuilder->setParameter($param, '%' . $word . '%');
                    if($wordAsDate)
                        $queryBuilder->setParameter($paramDate, $wordAsDate);

                    $i++;
                }
            }

            $results = $queryBuilder->getQuery()->getResult();
        }
        
        return new ViewModel(array(
            'form' => $form,
            'package' => $package,
            'results' => $results,
        ));
    }
    
    public function acceptMoveAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $order_id = (int) $this->params()->fromQuery('order_id', 0);
        $package_id = (int) $this->params()->fromQuery('package_id', 0);
        
        $form = new Form\AcceptMovePackage();
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $inputFilter = $this->getServiceLocator()
                    ->get('Admin\InputFilter\AcceptMovePackage');
            #$form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $data['package_id']));
                
                if($data['order_id'] == '') {
                    $order = new Entity\Order();
                    
                    $code = new Entity\Code();
                    $code->genCode();
                    $codecheck = 1;
                    while($codecheck != null) {
                        $code->genCode();
                        $codecheck = $entityManager->getRepository('ErsBase\Entity\Code')
                            ->findOneBy(array('value' => $code->getValue()));
                    }
                    $order->setCode($code);
                    
                    $buyer = $package->getParticipant();
                    $order->setBuyer($buyer);
                } else {
                    $order = $entityManager->getRepository('ErsBase\Entity\Order')
                        ->findOneBy(array('id' => $data['order_id']));
                    
                    
                    
                }
                
                $oldOrder = $package->getOrder();
                $log = new Entity\Log();
                $log->setUser($this->zfcUserAuthentication()->getIdentity());
                $log->setData('moved package '.$package->getCode()->getValue().' from order '.$oldOrder->getCode()->getValue().' to order '.$order->getCode()->getValue().': '.$data['comment']);
                
                $entityManager->persist($log);
                
                # initialize new package
                $newPackage = new Entity\Package();
                $code = new Entity\Code();
                $code->genCode();
                $newPackage->setCode($code);
                
                # set order for package
                $newPackage->setOrder($package->getOrder());
                
                foreach($package->getItems() as $item) {
                    if($item->hasParentItems()) {
                        continue;
                    }
                    $newItem = clone $item;
                    $newPackage->addItem($newItem);
                    
                    $statusTransferred = $entityManager->getRepository('ErsBase\Entity\Status')
                        ->findOneBy(array('value' => 'transferred'));
                    
                    $item->setStatus($statusTransferred);
                    $item->setTransferredItem($newItem);
                    
                    $code = new Entity\Code();
                    $code->genCode();
                    $newItem->setCode($code);
                    
                    $entityManager->persist($item);
                    $entityManager->persist($newItem);
                }
                $newPackage->setTransferredPackage($package);
                $newPackage->setOrder($order);
                $order->addPackage($newPackage);
                
                $entityManager->persist($newPackage);
                $entityManager->persist($order);
                #$entityManager->persist($package);
                $entityManager->flush();
                
                return $this->redirect()->toRoute('admin/order', array(
                    'action' => 'detail', 
                    'id' => $oldOrder->getId()
                ));
            } else {
                $logger->warn($form->getMessages());
            }
        }
        
        $order = null;
        if($order_id != 0) {
            $order = $entityManager->getRepository('ErsBase\Entity\Order')
                    ->findOneBy(array('id' => $order_id));
            $form->get('order_id')->setValue($order->getId());
        }
        
        $package = null;
        if($package_id != 0) {
            $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $package_id));
            $form->get('package_id')->setValue($package->getId());
        }
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('package')) {
            $forrest->set('package', 'admin/order', 
                    array('action' => 'search')
                );
        }
        
        return new ViewModel(array(
            'form' => $form,
            'order' => $order,
            'package' => $package,
            'breadcrumb' => $forrest->get('package'),
        ));
    }
    
    public function changeStatusAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/order', array());
        }
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $id));
        
        if(!$package) {
            throw new \Exception('Unable to find package with ir '.$id);
        }
        
        $form = new Form\SimpleForm($entityManager);
        
        #$form->bind($package);
        
        $form->get('submit')->setAttributes(array(
            'value' => _('save'),
            'class' => 'btn btn-success',
        ));

        $status = $entityManager->getRepository('ErsBase\Entity\Status')
                ->findBy(array(), array('position' => 'ASC'));
        
        $statusId = $package->getStatus()->getId();
        
        $statusOptions = array();
        $selected = false;
        foreach($status as $s) {
            $selected = false;
            if($statusId == $s->getId()) {
                $selected = true;
            }
            $statusOptions[] = array(
                'value' => $s->getId(),
                'label' => $s->getActive() ? 'active: '.$s->getValue() : 'inactive: '.$s->getValue(),
                'selected' => $selected,
            );
        }
        $form->add(array(
            'name' => 'status_id',
            'type'  => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => _('new status'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
                'value_options' => $statusOptions,
            ),
        ));
        $form->add(array(
            'name' => 'package_id',
            'type'  => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'required' => 'required',
                'value' => $package->getId(),
            ),
        ));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $status = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('id' => $data['status_id']));
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $data['package_id']));
                
                if(!$package instanceof \ErsBase\Entity\Package) {
                    throw new \Exception('Unable to find package with id: '.$data['package_id']);
                }
                
                $statusService = $this->getServiceLocator()
                    ->get('ErsBase\Service\StatusService');
                
                error_log('status: '.$status->getValue());
                
                $statusService->setPackageStatus($package, $status, true);
                
                $order = $package->getOrder();
                return $this->redirect()->toRoute('admin/order', array(
                    'action' => 'detail', 
                    'id' => $order->getId()
                ));
            } else {
                $logger->warn($form->getMessages());
            }
        }

        
        return new ViewModel(array(
            'form' => $form,
            'package' => $package,
        ));
    }
    
    public function changeCommentAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->flashMessenger()->addErrorMessage('Unable to find package without id.');
            return $this->redirect()->toRoute('admin/order', array());
        }
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        $package = $entityManager->getRepository('ErsBase\Entity\Package')
                ->findOneBy(array('id' => $id));
        
        if(!$package) {
            throw new \Exception('Unable to find package with id '.$id);
        }
        
        $form = new Form\SimpleForm($entityManager);
        
        $form->get('submit')->setAttributes(array(
            'value' => _('save'),
            'class' => 'btn btn-success',
        ));

        $form->add(array(
            'name' => 'comment',
            'type'  => 'textarea',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => _('comment'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
        $form->get('comment')->setValue($package->getComment());
        
        $form->add(array(
            'name' => 'package_id',
            'type'  => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'required' => 'required',
                'value' => $package->getId(),
            ),
        ));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                $package = $entityManager->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array('id' => $data['package_id']));
                
                if(!$package) {
                    throw new \Exception('Unable to find package with id '.$data['package_id']);
                }
                
                $package->setComment($data['comment']);
                
                $entityManager->persist($package);
                $entityManager->flush();
                
                $this->flashMessenger()->addSuccessMessage('Comment for for package '.$package->getCode()->getValue().' has been saved.');
                return $this->redirect()->toRoute('admin/order', array(
                    'action' => 'detail', 
                    'id' => $package->getOrder()->getId()
                ));
            } else {
                $logger->warn($form->getMessages());
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'package' => $package,
        ));
    }
}
