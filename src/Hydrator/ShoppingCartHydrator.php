<?php
/**
 *
 * @package ShoppingCart
 * @subpackage Hydrator
 * @author Aleksander Cyrkulewski
 */
namespace ShoppingCart\Hydrator;


/*
 * Currently, we require zendframework/zend-hydrator ^2.4
 *
 * This will need to change to support verion >=3.
 */
use Zend\Hydrator\ClassMethods;

class ShoppingCartHydrator extends ClassMethods
{


    /**
     * Extract values from an object
     *
     * @param object $object
     * @return array
     * @throws \Exception
     */
    public function extract($object) : array
    {
        if (! in_array('ShoppingCart\Entity\ShoppingCartEntityInterface', class_implements($object))) {
            throw new \Exception('$object must implement ShoppingCart\Entity\ShoppingCartEntityInterface');
        }

        $data = parent::extract($object);
        return $data;
    }


    /**
     * Hydrate $object with the provided $data.
     *
     * @param array $data
     * @param object $object
     * @return object
     * @throws \Exception
     */
    public function hydrate(array $data, $object)
    {
        if (! in_array('ShoppingCart\Entity\ShoppingCartEntityInterface', class_implements($object))) {
            throw new \Exception('$object must implement ShoppingCart\Entity\ShoppingCartEntityInterface');
        }
        return parent::hydrate($data, $object);
    }

}
