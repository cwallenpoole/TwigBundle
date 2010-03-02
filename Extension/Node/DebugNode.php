<?php

namespace Bundle\TwigBundle\Extension\Node;

class DebugNode extends \Twig_Node_Debug
{

  public function compile($compiler)
  {
    $compiler->addDebugInfo($this);

    $compiler
      ->write("if (\$this->env->isDebug())\n", "{\n")
      ->indent()
      ->write('var_export(')
    ;

    if (null === $this->expr)
    {
      $compiler->raw('array_diff_key( $context, array("view" => true, "_data" => true))');
    }
    else
    {
      $compiler->subcompile($this->expr);
    }

    $compiler
      ->raw(");\n")
      ->outdent()
      ->write("}\n")
    ;
  }

}