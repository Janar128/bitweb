<?php
namespace Line;

return array(
     'controllers' => array(
         'invokables' => array(
             'Line\Controller\Line' => 'Line\Controller\LineController',
         ),
     ),
     
     'router' => array(
         'routes' => array(
             'line' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/line[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Line\Controller\Line',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'line' => __DIR__ . '/../view',
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