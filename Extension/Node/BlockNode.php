<?php

namespace Bundle\TwigBundle\Extension\Node;

class BlockNode extends \Twig_Node_Block
{

  public function compile($compiler)
  {
    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("if(\$context['view']->slots->has('%s')) \n", $this->name))
      ->write("{\n")
      ->indent();
      
      $compiler->write(sprintf("\$context['view']->slots->output('%s', '", $this->name))
                ->indent();
        
        $compiler->subcompile($this->body);
      
      $compiler->outdent()
                ->write(sprintf("');"));
      
    $compiler
      ->outdent()
      ->write("}\n")
      ->write("else\n")
      ->write("{\n")
      ->indent();
      
      $compiler->write(sprintf("\$context['view']->slots->start('%s'); \n", $this->name))
                ->indent();
        
        $compiler->subcompile($this->body);
      
      $compiler->outdent()
                ->write(sprintf("\$context['view']->slots->stop(); \n"));
      
    $compiler
      ->outdent()
      ->write("}\n");
    
  }

}
