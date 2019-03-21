<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 21.03.19
 * Time: 12:50
 */

namespace SimplePool;

/**
 * Class Pool
 * @package Engine\Core
 */
class Pool
{
    /**
     * @var array
     */
    private $objects;
    
    /**
     * current objects index position
     * @var int
     */
    private $index;
    
    /**
     * @var boolean
     */
    private $hasFreeObject;
    
    /**
     * @var string
     */
    private $objectClass;
    
    /**
     * Pool constructor.
     * @param string $objectClass
     */
    public function __construct(string $objectClass)
    {
        $this->objectClass = $objectClass;
        $this->clear();
    }
    
    /**
     * @return mixed
     */
    public function obtain(): object
    {
        if ($this->hasFreeObject) {
            $object = $this->objects[$this->index--];
            
            $this->hasFreeObject = $this->index > 0;
        }
        else {
            $object = new $this->objectClass;
        }
        
        return $object;
    }
    
    /**
     * add object in pool
     * @param object $object
     */
    public function free(object $object)
    {
        $this->objects[$this->index++] = $object;
        $this->hasFreeObject = true;
    }
    
    /**
     * add a object array in pool
     * @param array $objects
     */
    public function freeAll(array $objects)
    {
        foreach ($objects as $object) {
            $this->free($object);
        }
    }
    
    /**
     *
     */
    public function clear()
    {
        $this->objects = [];
        $this->hasFreeObject = false;
        $this->index = 0;
    }
}