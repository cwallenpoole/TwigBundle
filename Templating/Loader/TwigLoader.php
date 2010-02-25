<?php

namespace Bundle\TwigBundle\Templating\Loader;

use Symfony\Components\Templating\Storage\FileStorage,
    Bundle\TwigBundle\Templating\Storage\TwigStorage,
    Symfony\Components\Templating\Loader\CompilableLoaderInterface as CompilableLoader;


class TwigLoader extends CompilableTwigLoader
{
  
  /**
   * Loads a template. This loader is used in the non cached environment 
   *
   * @param string $template The logical template name
   * @param array  $options  An array of options
   *
   * @return Storage|Boolean false if the template cannot be loaded, a Storage instance otherwise
   */
  public function load($template, array $options = array())
  {  
    $result = parent::load($template, $options);
    
    if($result instanceof FileStorage)
    {
      return new TwigStorage($this->compile($result->getContent()), null, 'twig');
    }
  
    return $result;
  }

}