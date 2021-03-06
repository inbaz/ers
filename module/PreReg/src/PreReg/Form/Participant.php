<?php   

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PreReg\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Session\Container;

class Participant extends Form implements InputFilterProviderInterface
{    
    protected $entityManager;
    protected $serviceManager;
    public function getEntityManager() {
        return $this->em;
    }
    public function setEntityManager($entityManager) {
        $this->em = $entityManager;
    }
    
    public function setServiceLocator($serviceManager) {
        $this->sm = $serviceManager;
        
        return $this;
    }
    public function getServiceLocator() {
        return $this->sm;
    }


    public function __construct()
    {
        parent::__construct('Participant');
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array( 
            'name' => 'firstname', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => _('First name...'), 
                'required' => 'required', 
                'class' => 'form-control form-element',
            ), 
            'options' => array( 
                'label' => _('First name'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'surname', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => _('Surname...'), 
                'required' => 'required', 
                'class' => 'form-control form-element',
            ), 
            'options' => array( 
                'label' => _('Surname'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'birthday', 
            'type' => 'PreReg\Form\Element\DateText',
            'attributes' => array( 
                'placeholder' => _('Birthday...'), 
                'required' => 'required',
                'class' => 'form-control form-element datepicker',
            ), 
            'options' => array( 
                'label' => _('Date of birth'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ), 
        ));
        $this->get('birthday')->setFormat('d.m.Y');
 
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Email', 
            'attributes' => array( 
                'placeholder' => _('Email Address...'), 
                'class' => 'form-control form-element',
            ), 
            'options' => array( 
                'label' => _('Email (optional)'), 
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ), 
        )); 
        
        $this->add(array(
            'name' => 'newsletter',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'value' => '0',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => _('I\'d like to receive information about the next EJC.'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
            ),
        ));
        
        $this->add(array(
            'name' => 'Country_id',
            'type'  => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => _('Where are you from?'),
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
 
        $this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
        )); 
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => _('Save'),
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
    
    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
                'validators' => array(
                ),
            ),
            'firstname' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                    array ( 
                        'name' => 'Callback', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => _('The provided name contains invalid character. These charaters are not allowed:').' !"§$%()=<>|^;{}[]',
                            ),
                            'callback' => function($value, $context=array()) {
                                $alphabet = '!"§$%()=<>|^;{}[]';
                                $alpha = str_split($alphabet);
                                foreach($alpha as $char) {
                                    if(strstr($value, $char)) {
                                        return false;
                                    }
                                }
                                return true;
                            },
                            
                        ),
                    ),
                ), 
            ),
            'surname' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ),
                'validators' => array( 
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                    array ( 
                        'name' => 'Callback', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => _('The provided name contains invalid character. These charaters are not allowed:').' !"§$%()=<>|^;{}[]',
                            ),
                            'callback' => function($value, $context=array()) {
                                $alphabet = '!"§$%()=<>|^;{}[]';
                                $alpha = str_split($alphabet);
                                foreach($alpha as $char) {
                                    if(strstr($value, $char)) {
                                        return false;
                                    }
                                }
                                return true;
                            },
                            
                        ),
                    ),
                ),
            ),
            'birthday' => array(
                'required' => true,
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'format' => 'd.m.Y',
                        ),
                    ),
                    array(
                        'name' => 'Callback', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => _('Please choose a valid birthday'),
                            ),
                            'callback' => function($value, $context=array()) {
                                $min = \DateTime::createFromFormat('d.m.Y', '01.01.1900');
                                $max = new \DateTime();
                                $birthday = \DateTime::createFromFormat('d.m.Y', $value);
                                if(!$birthday instanceof \DateTime) {
                                    return false;
                                }
                                if($min->getTimestamp() > $birthday->getTimestamp()) {
                                    return false;
                                }
                                if($max->getTimestamp() < $birthday->getTimestamp()) {
                                    return false;
                                }
                                return true;
                            },
                        ),
                    ),
                ),
            ),
            'email' => array(
                'required' => false,
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array ( 
                        'name' => 'EmailAddress', 
                        'options' => array( 
                            'messages' => array( 
                                'emailAddressInvalidFormat' => _('Email address format is not invalid'), 
                            ) 
                        ), 
                    ),
                    # Check if another user already has this email
                    array (
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => _('A person with this email address already exists. To make changes to your existing order contact prereg@eja.net or choose another e-mail'),
                            ),
                            'callback' => function($value, $context=array()) {
                                $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                                $user = $entityManager->getRepository('ErsBase\Entity\User')
                                        ->findOneBy(array('email' => $value));

                                # The email address is new -> ok
                                if (!$user) {
                                    return true;
                                }

                                # The email address belongs to the current user -> ok
                                if($user->getId() == $context['id']) {
                                    return true;
                                }
                                
                                $auth = $this->getServiceLocator()
                                        ->get('zfcuser_auth_service');
                                $identity = $auth->getIdentity();
                                if(!empty($identity) && $identity->getEmail() == $user->getEmail()) {
                                    return true;
                                }
                                
                                if(count($user->getRoles()) == 0) {
                                    $now = new \DateTime();
                                    $diff = $now->getTimestamp()-$user->getUpdated()->getTimestamp();
                                    if($diff > 3600) {
                                        return true;
                                    }
                                }
                                
                                # The email address belongs to another user -> not ok
                                return false;
                            },
                        ),
                    ),
                ), 
            ),
            'newsletter' => array(
                'required' => false,
                'filters' => array( 
                    array('name' => 'Int'), 
                ), 
                'validators' => array(
                ),
            ),
            'Country_id' => array(
                'required' => true,
                'filters' => array( 
                    array('name' => 'Int'), 
                ), 
                'validators' => array(
                ),
            ),
            /*'price' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Float',
                    ),
                ),
            ),*/
        );
    }
}
