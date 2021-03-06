<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ErsBase\Service;

use Zend\Session\Container;
use ErsBase\Entity;
use Zend\View\Model\ViewModel;

/**
 * order service
 */
class OrderService
{
    protected $_sl;
    protected $currency;
    protected $order;
    
    public function __construct() {
        
    }
    
    /**
     * set ServiceLocator
     * 
     * @param ServiceLocator $sl
     */
    public function setServiceLocator($sl) {
        $this->_sl = $sl;
    }
    
    /**
     * get ServiceLocator
     * 
     * @return ServiceLocator
     */
    protected function getServiceLocator() {
        return $this->_sl;
    }
    
    public function setCurrency(Entity\Currency $currency) {
        $this->currency = $currency;
    }
    public function getCurrency() {
        if(!$this->currency) {
            $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
            $container = new Container('ers');
            $this->currency = $entityManager->getRepository('ErsBase\Entity\Currency')
                    ->findOneBy(array('short' => $container->currency));
        }
        return $this->currency;
    }
    
    public function setOrder(Entity\Order $order) {
        $this->order = $order;
    }
    
    public function getOrder() {
        if($this->order instanceof Entity\Order) {
            return $this->order;
        }
        $container = new Container('ers');
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        $entityManager->flush();
        if(isset($container->order_id) && is_numeric($container->order_id)) {
            $checkOrder = $entityManager->getRepository('ErsBase\Entity\Order')
                    ->findOneBy(array('id' => $container->order_id));
            if($checkOrder) {
                $this->order = $checkOrder;
                $this->addLoggedInUser();
                return $checkOrder;
            }
        }
        
        $newOrder = $this->createNewOrder();

        $container->order_id = $newOrder->getId();

        $this->order = $newOrder;
        $this->addLoggedInUser();

        return $newOrder;
    }
    
    private function createNewOrder() {
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        #$newOrder = new Entity\Order();
        $newOrder = $this->getServiceLocator()
                ->get('ErsBase\Entity\Order');
        $status = $entityManager->getRepository('ErsBase\Entity\Status')
            ->findOneBy(array('value' => 'order pending'));
        $newOrder->setStatus($status);
        /*$container = new Container('ers');
        $currency = $entityManager->getRepository('ErsBase\Entity\Currency')
            ->findOneBy(array('short' => $container->currency));
        $newOrder->setCurrency($currency);*/

        $entityManager->persist($newOrder);
        $entityManager->flush();
        
        return $newOrder;
    }
    
    public function updateShoppingCart() {
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        $debug = true;
        $order = $this->getOrder();
        #$currency = $order->getCurrency();
        foreach($order->getPackages() as $package) {
            $participant = $package->getParticipant();

            $agegroupService = $this->getServiceLocator()
                    ->get('ErsBase\Service\AgegroupService');
            $agegroupService->setMode('price');
            $agegroup = $agegroupService->getAgegroupByUser($participant);
            if($debug) {
                if($agegroup != null) {
                    error_log('found agegroup: '.$agegroup->getName());
                }
            }

            $deadlineService = $this->getServiceLocator()
                    ->get('ErsBase\Service\DeadlineService');
            $deadlineService->setMode('price');
            $deadline = $deadlineService->getDeadline($order->getCreated());
            if($debug) {
                if($deadline != null) {
                    error_log('found deadline: '.$deadline->getName());
                }
            }

            foreach($package->getItems() as $item) {
                if($item->getStatus() == 'refund') {
                    continue;
                }
                if($item->hasParentItems()) {
                    continue;
                }
                $product = $item->getProduct();
                $price = $product->getProductPrice($agegroup, $deadline, $package->getCurrency());

                $item->setPrice($price->getFullCharge());
                $entityManager->persist($item);
            }
        }
        $entityManager->persist($order);
        $entityManager->flush();
    }
    
    public function changeCurrency($paramCurrency) {
        $debug = false;
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        if(! $paramCurrency instanceof Entity\Currency) {
            $currency = $entityManager->getRepository('ErsBase\Entity\Currency')
                ->findOneBy(array('short' => $paramCurrency));
                if($debug) {
			error_log('got currency from database: '.$currency->getShort());
		}
        } else {
            $currency = $paramCurrency;
                if($debug) {
			error_log('got currency from param: '.$currency->getShort());
		}
        }
        $order = $this->getOrder();
        if($order->getCurrency()->getShort() != $currency->getShort()) {
            foreach($order->getPackages() as $package) {
                $package->setCurrency($currency);
                if($debug) {
                    error_log('set package to currency: '.$currency);
                }
                foreach($package->getItems() as $item) {
                    $item->setCurrency($currency);
                    if($debug) {
                        error_log('set item to currency: '.$currency);
                    }
                    if($item->hasParentItems()) {
                        continue;
                    }
                    $product = $item->getProduct();
                    $participant = $item->getPackage()->getParticipant();

                    $agegroupService = $this->getServiceLocator()
                            ->get('ErsBase\Service\AgegroupService');
                    $agegroupService->setMode('price');
                    $agegroup = $agegroupService->getAgegroupByUser($participant);
                    #$agegroup = $participant->getAgegroup();

                    $deadlineService = $this->getServiceLocator()
                            ->get('ErsBase\Service\DeadlineService');
                    $deadlineService->setMode('price');
                    $deadline = $deadlineService->getDeadline($order->getCreated());

                    $price = $product->getProductPrice($agegroup, $deadline, $currency);
                    if($debug) {
                        error_log('price: '.$price->getFullCharge());
                    }
                    if(!$price) {
                        throw new \Exception('Unable to find price for '.$product->getName().'.');
                    }
                    $item->setPrice($price->getFullCharge());
                    #$entityManager->persist($item);
                }
                #$entityManager->persist($package);
            }
            $order->setCurrency($currency);
            if($debug) {
                error_log('set order to currency: '.$currency);
            }
            if($order->getPaymentType()) {
                $order->setPaymentType(null);
            }
            $entityManager->persist($order);
            $entityManager->flush();
        }
        
        return $this;
    }
    
    public function addLoggedInUser() {
        $auth = $this->getServiceLocator()
                ->get('zfcuser_auth_service');
        if ($auth->hasIdentity()) {
            $login_email = $auth->getIdentity()->getEmail();

            $order = $this->getOrder();
            $package = $order->getPackageByParticipantEmail($login_email);
            if(!$package) {
                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                $user = $entityManager->getRepository('ErsBase\Entity\User')
                        ->findOneBy(array('email' => $login_email));
                $this->addParticipant($user);
            }
        }
        
    }
    
    public function setCountryId($country_id) {
        $container = new Container('ers');
        $container->country_id = $country_id;
    }
    
    public function getCountryId() {
        $container = new Container('ers');
        return $container->country_id;
    }
    
    /**
     * Add Participant (add new Package and set participant)
     * 
     * @param \Entity\User $participant
     * @return \Entity\Order
     */
    
    public function addParticipant(Entity\User $participant) {
        $package = new Entity\Package();
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        $status = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'order pending'));
        if(!$status) {
            throw new \Exception('Please setup status "order pending"');
        }
        
        $package->setStatus($status);
        $status->addPackage($package);
        
        $package->setParticipant($participant);
        
        $this->getOrder()->addPackage($package);
        $package->setOrder($this->getOrder());
        
        return $this->getOrder();
    }
    
    public function removeParticipant(Entity\User $participant, $flush=true) {
        if(!$participant) {
            throw new \Exception('Unable to find participant with id: '.$id);
        }
        
        # remove package of the active order
        $package = $this->getOrder()->getPackageByParticipantId($participant->getId());
        if(!$package) {
            throw new \Exception('Unable to find package for participant id: '.$participant->getId());
        }
        
        $this->removePackage($package, false);
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        #$entityManager->remove($package);
        if(!$participant->getActive()) {
            foreach($participant->getPackages() as $oldPackage) {
                $this->removePackage($oldPackage, false);
                #$entityManager->remove($oldPackage);
            }
            $entityManager->remove($participant);
        }
        if($participant->getId() == $this->getOrder()->getBuyerId()) {
            $this->getOrder()->setBuyer(null);
            $this->getOrder()->setBuyerId(null);
            $container = new Container('ers');
            if(!is_array($container->checkout)) {
                $container->checkout = array();
            }
            $container->checkout['/order/buyer'] = 0;
        }
        
        if($flush) {
            $entityManager->flush();
        }
    }
    
    public function removePackage(Entity\Package $package, $flush=true) {
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        
        foreach($package->getItems() as $item) {
            error_log('removing item '.$item->getName().' ('.$item->getId().')');
            #$item->setPackage(null);
            $package->removeItem($item);
            $entityManager->remove($item);
        }
        $package->setParticipant(null);
        $entityManager->remove($package);
        if($flush) {
            $entityManager->flush();
        }
    }
    
    public function removeItemById($item_id) {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $item = $entityManager->getRepository('ErsBase\Entity\Item')
            ->findOneBy(array('id' => $item_id));
        if(!$item) {
            throw new \Exception('Unable to remove item with id: '.$item_id);
        }
        foreach($item->getChildItems() as $cItem) {
            error_log('remove child item '.$cItem->getName());
            $entityManager->remove($cItem);
        }
        error_log('remove item '.$item->getName());
        $entityManager->remove($item);
        $entityManager->flush();
    }
    
    public function recalcPackage(Entity\Package $package, $agegroup, $deadline) {
        $itemArray = array();
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $statusOrdered = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'ordered'));
        $statusPaid = $entityManager->getRepository('ErsBase\Entity\Status')
                    ->findOneBy(array('value' => 'paid'));
        
        foreach($package->getItems() as $item) {
            if($item->getStatus() == 'refund') {
                continue;
            }
            if($item->hasParentItems()) {
                continue;
            }
            $product = $item->getProduct();
            #$price = $product->getProductPrice($agegroup, $deadline);
            $price = $product->getProductPrice($agegroup, $deadline, $package->getCurrency());
            
            if($item->getPrice() != $price->getFullCharge()) {
                /*
                 * disable item and create new item
                 */
                #$newItem = clone $item;
                $newItem = new Entity\Item();
                $newItem->populate($item->getArrayCopy());
                #$newItem->setStatus($item->getStatus());
                foreach($item->getItemVariants() as $itemVariant) {
                    $newItemVariant = clone $itemVariant;
                    $newItem->addItemVariant($newItemVariant);
                    $newItemVariant->setItem($newItem);
                }
                $newItem->setPrice($price->getFullCharge());

                $newItem->setProduct($item->getProduct());
                $newItem->setPackage($item->getPackage());
                
                if($newItem->getPrice() == 0) {
                    # set item to paid if it's 0 € worth
                    $newItem->setStatus($statusPaid);
                } elseif($item->getStatus()->getValue() == 'paid') {
                    # if it's not 0 € worth set the item to ordered when it was paid.
                    $newItem->setStatus($statusOrdered);
                } else {
                    # let the item in the old state otherwise
                    $newItem->setStatus($item->getStatus());
                }
                
                $code = new Entity\Code();
                $code->genCode();
                $codecheck = 1;
                while($codecheck != null) {
                    $code->genCode();
                    $codecheck = $entityManager->getRepository('ErsBase\Entity\Code')
                        ->findOneBy(array('value' => $code->getValue()));
                }
                $newItem->setCodeId(null);
                $newItem->setCode($code);

                /*
                 * add subitems to main item
                 */
                foreach($item->getChildItems() as $cItem) {
                    $itemPackage = new Entity\ItemPackage();
                    $itemPackage->setSurItem($newItem);
                    $itemPackage->setSubItem($cItem);
                    $newItem->addItemPackageRelatedBySurItemId($itemPackage);
                }

                $itemArray[$item->getId()]['after'] = $newItem;
            }
            $itemArray[$item->getId()]['before'] = $item;
        }
        return $itemArray;
    }
    
    public function saveRecalcPackage(Entity\Package $package, $agegroup, $deadline) {
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $statusCancelled = $entityManager->getRepository('ErsBase\Entity\Status')
                        ->findOneBy(array('value' => 'cancelled'));

        $itemArray = $this->recalcPackage($package, $agegroup, $deadline);
                
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
    }
    
    public function sendPaymentReminder() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $emailService = $this->getServiceLocator()
                ->get('ErsBase\Service\EmailService');

        $order = $this->getOrder();
        $buyer = $order->getBuyer();
        $recipients[] = [
            'email' => $buyer,
            'type' => 'to',
        ];

        $settingService = $this->getServiceLocator()
                ->get('ErsBase\Service\SettingService');

        if($settingService->get('ers.bcc_mail') != '') {
            $recipients[] = [
                'email' => $settingService->get('ers.bcc_mail'),
                'type' => 'bcc',
            ];
        }

        #$subject = "[".$settingService->get('ers.name_short')."] Payment reminder for your order: ".$order->getCode()->getValue();
        $subject = "[".$settingService->get('ers.name_short')."] Zahlungserinnerung für deine Bestellung: ".$order->getCode()->getValue();

        $viewModel = new ViewModel(array(
            'order' => $order,
        ));
        $viewModel->setTemplate('email/payment-reminder.phtml');
        $viewRender = $this->getServiceLocator()->get('ViewRenderer');
        $html = $viewRender->render($viewModel);

        $shortcodeService = $this->getServiceLocator()
                ->get('ErsBase\Service\ShortcodeService');
        $shortcodeService->setText($html);
        $shortcodeService->setObject('order', $order);
        $shortcodeService->setObject('buyer', $order->getBuyer());
        $shortcodeService->processFilters();
        $html = $shortcodeService->getText();
        
        $emailService->addMailToQueue(null, $recipients, $subject, $html, true);

        $logger->info('payment reminder for order '.$order->getCode()->getValue().' has been send out.');
        
        $entityManager = $this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        $order->setPaymentReminderStatus(($order->getPaymentReminderstatus()+1));
        $entityManager->persist($order);
        $entityManager->flush();
    }
}
