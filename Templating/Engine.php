<?php

namespace Bundle\TwigBundle\Templating;

use Symfony\Framework\WebBundle\Templating\Engine as BaseEngine;

/**
 * This engine etends the default engine with array access
 * For itegrating helpers with twig templating engine
 *
 * @package symfony
 * @author  Ad van der Veer
 */
class Engine extends BaseEngine implements \ArrayAccess
{

  /**
   * Check wether an helper is set
   * 
   * @param string $name - Helper name
   * @return boolean
   */
  public function offsetExists( $name )
  {
    return $this->has($name);
  }

  /**
   * Get an Helper from the Engine
   * 
   * @access public
   * @param string $name - Helper name
   * @return Helper Object
   */
  public function offsetGet( $name )
  {
    return $this->get($name);
  }



  public function offsetUnset( $offset )
  {
    throw new Exception('Unsetting Helpers from the Engine is not supported');    
  }
  
  public function offsetSet( $name, $value)
  {
    throw new Exception('Setting Helpers from the Engine is not supported');        
  }

}