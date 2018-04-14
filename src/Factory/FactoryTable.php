<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 17/03/2018
 * Time: 17:07
 */

namespace Table\Factory;



class FactoryTable
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke($container, $requestedName, array $options = null)
    {
       return new $requestedName($container,$options);
    }
}