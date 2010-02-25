<?php

namespace Bundle\TwigBundle\Templating\Loader;

use Symfony\Components\Templating\Loader\FilesystemLoader as BaseLoader,
    Symfony\Components\Templating\Loader\CompilableLoaderInterface as CompilableLoader,
    Bundle\TwigBundle\Templating\Storage\TwigStorage;

class CompilableTwigLoader extends BaseLoader implements CompilableLoader
{
  
  protected $twig;
  
  
  /**
   * Constructor.
   *
   * @param array $templatePathPatterns An array of path patterns to look for templates
   */
  public function __construct(\Twig_Environment $twig, $templatePathPatterns)
  {
   $this->twig = $twig;
   $this->defaultOptions['renderer'] = 'twig';
   
   return parent::__construct($templatePathPatterns); 
  }
  
  /**
   * Compiles a twig template.
   *
   * @param string $template The template to compile
   *
   * @return string The compiled template
   *
   * @throws \Exception if the template is not compilable
   */
  public function compile($template)
  {
    $stream = $this->twig->tokenize($template, md5($template));
    $nodes = $this->twig->parse($stream);
    $php = $this->twig->compile($nodes);

    return $php;
  }
  
  /**
   * Use the Filesystem loader to load te file, then store in
   * into a TwigStorage.
   * 
   * @param mixed $template
   * @param array array $options. (default: array())
   */
  public function load($template, array $options = array())
  {
    $storage = parent::load($template, $options);

    if(!empty($storage))
    {
      return new TwigStorage($storage->getContent(), (string) $storage, 'twig');
    }
    
    return $storage;
  }

}