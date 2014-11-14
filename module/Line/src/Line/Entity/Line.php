<?php
  
namespace Line\Entity;
  
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
  
/**
 * Line entity
 *
 * @ORM\Entity
 * @ORM\Table(name="line")
 * @property string $name
 * @property float $description
 * @property float $added
 * @property int $id
 */
class Line implements InputFilterAwareInterface 
{
    protected $inputFilter;
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
  
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
  
    /**
     * @ORM\Column(type="string")
     */
    protected $description;
	
	/**
     * @ORM\Column(type="datetime")
     */
    protected $added;
	
	protected $busStops;
 
    public function __construct()
    {
        $this->busStops = new \Doctrine\Common\Collections\ArrayCollection();
    }
  
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
  
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }
  
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
  
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray($data = array()) 
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
		$this->added = $data['added'];
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
                            'max'      => 100,
                        ),
                    ),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'name',
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
                'validators' => array(
                	array(
						'name' => 'datetime'
					)
				)
            ));
 
            $this->inputFilter = $inputFilter;
        }
 
        return $this->inputFilter;
    }
}