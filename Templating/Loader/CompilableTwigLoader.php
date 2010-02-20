<?php

namespace Bundle\TwigBundle\Templating\Loader;

use Symfony\Components\Templating\Loader\FilesystemLoader as BaseLoader,
    Symfony\Components\Templating\Storage\FileStorage,
    Symfony\Components\Templating\Storage\StringStorage,
    Symfony\Components\Templating\Loader\CompilableLoaderInterface as CompilableLoader;

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
    
    //search for the class name we just generated
    preg_match('/class[ ]*(?<class>.*)[ ]*extends/i', $php, $matches);
    
    if(empty($matches['class']))
    {
      throw new Exception('Compile Error: Generated Twig Template class not found');
    }
    
    $class = trim($matches['class']);
    
    $php .= <<<EOF
\$template = new $class(\$view->get('twig')->getTwigEnvironment());
\$template->display(\$parameters);
EOF;

    return $php;
  }

}