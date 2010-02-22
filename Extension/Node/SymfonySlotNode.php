<?php

namespace Bundle\TwigBundle\Extension\Node;

class SymfonySlotNode extends \Twig_Node implements \Twig_NodeListInterface
{

  protected $name;
  protected $body;
  protected $parent;

  public function __construct($name, \Twig_NodeList $body, $lineno, $parent = null, $tag = null)
  {
    parent::__construct($lineno, $tag);
    $this->name = $name;
    $this->body = $body;
    $this->parent = $parent;
  }
  
  public function compile($compiler)
  {
  
    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("public function block_%s(\$context)\n", $this->name), "{\n")
      ->indent()
    ;

    $compiler
      ->subcompile($this->body)
      ->outdent()
      ->write("}\n\n")
    ;
  
  }
  
  public function getNodes()
  {
    return $this->body->getNodes();
  }

  public function setNodes(array $nodes)
  {
    $this->body = new \Twig_NodeList($nodes, $this->lineno);
  }


}