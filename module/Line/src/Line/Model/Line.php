<?php
namespace Line\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

 class Line implements InputFilterAwareInterface
 {
     public $id;
     public $name;
     public $description;
	 public $added;
	 protected $inputFilter; 

     public function exchangeArray($data)
     {
         $this->id   = (!empty($data['id'])) ? $data['id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->description  = (!empty($data['description'])) ? $data['description'] : null;
		 $this->added  = (!empty($data['added'])) ? $data['added'] : null;
     }
	 
	 public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }
	 
	 public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'name',
                 'required' => true,
                 'filters'  => array(
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
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'description',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 0,
                             'max'      => 255,
                         ),
                     ),
                 ),
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'added',
                 'required' => true,
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
 }