<?php

namespace Bundle\TwigBundle\Templating;

use Symfony\Framework\WebBundle\Templating\Engine as BaseEngine;
use Symfony\Components\Templating\Loader\LoaderInterface;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Bundle\TwigBundle\Templating\Renderer\TwigRenderer;

/**
 * This engine etends the default engine with array access
 * For itegrating helpers with twig templating engine
 *
 * @package symfony
 * @author  Ad van der Veer
 */
class Engine extends BaseEngine implements \ArrayAccess
{

  protected $twig;

  public function __construct(ContainerInterface $container, LoaderInterface $loader, array $renderers = array(), $escaper)
  {
    $renderers['twig'] = new TwigRenderer();
  
    return parent::__construct($container, $loader, $renderers, $escaper);
  }

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