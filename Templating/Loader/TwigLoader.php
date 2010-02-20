<?php

namespace Bundle\TwigBundle\Templating\Loader;

use Symfony\Components\Templating\Storage\FileStorage,
    Symfony\Components\Templating\Storage\StringStorage,
    Symfony\Components\Templating\Loader\CompilableLoaderInterface as CompilableLoader;

class TwigLoader extends CompilableTwigLoader
{
  
  /**
   * Loads a template.
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
      $result = new StringStorage($this->compile($result->getContent()).' ?>');
    }
  
    return $result;
  }

}