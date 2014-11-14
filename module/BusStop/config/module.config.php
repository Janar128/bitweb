<?php
namespace BusStop;

return array(
     'controllers' => array(
         'invokables' => array(
             'BusStop\Controller\BusStop' => 'BusStop\Controller\BusStopController',
         ),
     ),
     
     'router' => array(
         'routes' => array(
             'busstop' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/busstop[/][:action][/:slug]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'slug'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'BusStop\Controller\BusStop',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'busstop' => __DIR__ . '/../view',
         ),
     ),
     
	 // Doctrine config
     'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
 );