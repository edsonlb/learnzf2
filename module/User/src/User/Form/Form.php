<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Form\Annotation\AbstractArrayOrStringAnnotation;

class User extends Form{
    
    public function __construct($name = 'user'){
        parent::__construct($name);
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Emenent\Email',
            'options' => array('label' => 'Email:'),
            'attributes' => array('type' => 'email','required' => 'required','placeholder' => 'Email Adress...',),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Emenent\Password',
            'options' => array('label' => 'Password:'),
            'attributes' => array('required' => 'required','placeholder' => 'Password Here...',),
        ));
        
        $this->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Emenent\Password',
            'options' => array('label' => 'Password Verify:'),
            'attributes' => array('required' => 'required','placeholder' => 'Password Verify Here...',),
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Emenent\Text',
            'options' => array('label' => 'Name:'),
            'attributes' => array('required' => 'required','placeholder' => 'Type name...',),
        ));
        
        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone number',
            ),
            'attributes' => array('type' => 'tel', 'required' => 'required', 'pattern' => '^[\d-/]+$',),
        ));
        
        $this->add(array(
            'name' => 'photo',
            'type' => 'Zend\Form\Emenent\File',
            'options' => array('label' => 'Your photo:'),
            'attributes' => array('required' => 'required','id' => 'photo',),
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Emenent\Csrf',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Emenent\Submit',
            'attributes' => array('value' => 'Submit', 'required' => 'false'),
        ));
    }
    
    public function getInputFilter(){
        if (!$this->filter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                'emailAddressInvalidFormat' => 'Email Address format is not valid!!!',
                            ),
                        ),
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Email adress is required!!!',
                            ),
                        ),
                    ),
                ),
            )));
            
            $this->filter = $inputFilter;
        }
        
        return $this->filter;
    }
    
}