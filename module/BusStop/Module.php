<?php
namespace BusStop;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use BusStop\Model\BusStop;
use BusStop\Model\BusStopTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
	 
	 public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'BusStop\Model\BusStopTable' =>  function($sm) {
                     $tableGateway = $sm->get('BusStopTableGateway');
                     $table = new BusStopTable($tableGateway);
                     return $table;
                 },
                 'BusStopTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new BusStop());
                     return new TableGateway('busstop', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }