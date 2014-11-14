<?php
namespace BusStop\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

 class BusStop implements InputFilterAwareInterface
 {
     public $id;
     public $name;
     public $lat;
	 public $lng;
	 protected $inputFilter; 

     public function exchangeArray($data)
     {
         $this->id   = (!empty($data['id'])) ? $data['id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->lat  = (!empty($data['lat'])) ? $data['lat'] : null;
		 $this->lng  = (!empty($data['lng'])) ? $data['lng'] : null;
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
                 'name'     => 'lat',
                 'required' => true,
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'lng',
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