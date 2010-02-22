<?php

namespace Bundle\TwigBundle\Extension\Node;

class ExtendsNode extends \Twig_Node
{
  protected $parent;

  public function __construct($lineno, $parent)
  {
    parent::__construct($lineno);
    
    $this->parent = $parent;
  }
  
  public function __toString()
  {
    return get_class($this).'('.$this->parent.')';
  }
  
  public function compile($compiler)
  {
    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("\$context['view']->extend('%s')", $this->parent))
      ->raw(";\n");
  
  }

}