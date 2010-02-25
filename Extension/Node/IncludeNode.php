<?php

namespace Bundle\TwigBundle\Extension\Node;

class IncludeNode extends \Twig_Node
{
  protected $name,
            $variables;
  
  public function __construct(\Twig_Node_Expression $name, $lineno, \Twig_Node_Expression_Array $variables = null, $tag = null)
  {
    parent::__construct($lineno, $tag);
    
    $this->name = $name;
    $this->variables = $variables;
  }
  
  public function compile($compiler)
  {
  
    $compiler
      ->addDebugInfo($this)
      ->write("echo \$context['view']->render(")
      ->subcompile($this->name)
      ->raw(", ");

    if (null === $this->variables)
    {
      $compiler->raw('$context');
    }
    else
    {
      $compiler->subcompile($this->variables);
    }

    $compiler
      ->raw(");\n");
  
  }

}