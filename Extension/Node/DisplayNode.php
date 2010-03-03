<?php

namespace Bundle\TwigBundle\Extension\Node;

class DisplayNode extends \Twig_Node
{

  protected $name;
  protected $default;
  protected $parent;

  public function __construct($name, \Twig_NodeList $default, $lineno, $parent = null, $tag = null)
  {
    parent::__construct($lineno, $tag);
    $this->name = $name;
    $this->default = $default;
    $this->parent = $parent;
  }

  public function compile($compiler)
  {
  
  
  
    $compiler->addDebugInfo($this)
             ->write(sprintf("if(\$context['view']->slots->has('%s')) \n", $this->name))
             ->write("{ \n")
             ->indent()
             ->write(sprintf("\$context['view']->slots->output('%s'); \n", $this->name))
             ->outdent()
             ->write("} \n")
             ->write("else \n")
             ->write("{\n")
             ->indent()
             ->subcompile($this->default)
             ->outdent()
             ->write("} \n \n");
/*
  
    $compiler->addDebugInfo($this)
             ->write("ob_start(); \n")
             ->indent()
             ->subcompile($this->default)
             ->outdent()
             ->write("\$default = ob_get_contents(); ob_end_clean(); \n\n");
  
    $compiler->write(sprintf("\$context['view']->slots->output('%s', \$default); \n\n", $this->name));
*/

  }

}