<?php

namespace Bundle\TwigBundle\Extension\Node;

class IncludeNode extends \Twig_Node
{
  protected $name,
            $variables,
            $sandboxed;
  
  public function __construct(\Twig_Node_Expression $name, $lineno, $sandboxed, \Twig_Node_Expression_Array $variables = null, $tag = null)
  {
    parent::__construct($lineno, $tag);
    
    $this->name = $name;
    $this->variables = $variables;
    $this->sandboxed = $sandboxed;
  }
  
  public function compile($compiler)
  {
  
    if (!$compiler->getEnvironment()->hasExtension('sandbox') && $this->sandboxed)
    {
      throw new \Twig_SyntaxError('Unable to use the sanboxed attribute on an include if the sandbox extension is not enabled.', $this->lineno);
    }
    
    if ($this->sandboxed)
    {
      $compiler
        ->write("\$sandbox = \$this->env->getExtension('sandbox');\n")
        ->write("\$alreadySandboxed = \$sandbox->isSandboxed();\n")
        ->write("\$sandbox->enableSandbox();\n")
      ;
    }
  
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
      
    if ($this->sandboxed)
    {
      $compiler
        ->write("if (!\$alreadySandboxed)\n", "{\n")
        ->indent()
        ->write("\$sandbox->disableSandbox();\n")
        ->outdent()
        ->write("}\n")
      ;
    }
  
  }

}