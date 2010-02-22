<?php

namespace Bundle\TwigBundle\Extension\Node;

class SetSlotNode extends \Twig_Node
{
  protected $name,
            $default;

  public function __construct($name, $lineno, $default = null)
  {

    parent::__construct($lineno);
    
    $this->name = $name;
    $this->default = $default;
  }
  
  public function __toString()
  {
    return get_class($this).'('.$this->name.', $default = '.$this->default.')';
  }
  
  public function compile($compiler)
  {
    $compiler
      ->addDebugInfo($this);
      
      
    if(is_null($this->default))
    {
      $compiler->write(sprintf("\$context['view']->slots->output('%s');", $this->name));
    }
    else
    {
      $compiler->write(sprintf("\$context['view']->slots->output('%s', ", $this->name))
               ->string($this->default)
               ->write(');');
    }
    
    $compiler->raw("\n\n");
  }

}