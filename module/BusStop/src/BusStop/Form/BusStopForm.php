<?php
 namespace BusStop\Form;

 use Zend\Form\Form;

 class BusStopForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('busstop');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         $this->add(array(
             'name' => 'lat',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Latitude',
             ),
         ));
		 $this->add(array(
             'name' => 'lng',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Longitude',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }