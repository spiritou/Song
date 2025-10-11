<?php

namespace App\Core;

class container 
{
    public function get($class)
    {
        $container = new \ReflectionClass($class);
        $constructor = $container->getConstructor();
        if(is_null($constructor))
        {
            return new $class;
        }

        $dependencies = [];
        foreach($constructor->getParameters() as $parameter)
        {
            $type = $parameter->gettype();
            if($type && !$type->isBuiltin())
            {
               $deepclass = $type->getName();
                $dependencies[] = $this->get($deepclass);
                // var_dump($dependencies);
            }
           
        }
        return $container->newInstanceArgs($dependencies);
    }
}