<?php

namespace Bundle\TwigBundle\Templating\Renderer;

use Symfony\Components\Templating\Renderer\PhpRenderer;
use Symfony\Components\Templating\Storage\Storage;
use Symfony\Components\Templating\Storage\StringStorage;

/**
 * PhpRenderer is a renderer for Twig Template
 *
 * @package    twigBundle
 * @subpackage templating
 * @author     Ad van der Veer
 */
class TwigRenderer extends PhpRenderer
{

  /**
   * Used the twig storage to render output.
   * The storage may be linked to a file in a cached environmente. we use
   * require in this case.
   * 
   * @access public
   * @param Storage $template
   * @param array array $parameters. (default: array())
   */
  public function evaluate(Storage $storage, array $parameters = array())
  {
    
    $content = $storage->getContent();
    $twig = $this->engine->get('twig')->getTwigEnvironment();
    $parameters['view'] = $this->engine;
    
    //retrieve the template class as effcient as possible
    if(!$class = trim(substr(strstr( strstr($content, "extends", true), 'class'), 5)))
    {
      return false;
    }
  
    //if is not yet defined use the code to do so
    if(!class_exists($class, false))
    {
      if($storage->isFiled())
      {
        require (string) $storage;
      }
      else
      {
        eval(substr($content, 5));
      }
    }
    
    //initiaze and display the template
    $template = new  $class($twig);      
    
    ob_start();
    $template->display($parameters);

    return ob_get_clean();
      
  }
}
