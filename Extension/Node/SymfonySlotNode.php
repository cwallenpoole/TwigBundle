<?php

namespace Bundle\TwigBundle\Extension\Node;

class SymfonySlotNode extends \Twig_Node implements \Twig_NodeListInterface
{

  protected $name;
  protected $body;

  public function __construct($name, \Twig_NodeList $body, $lineno, $parent = null, $tag = null)
  {
    parent::__construct($lineno, $tag);
    $this->name = $name;
    $this->body = $body;
  }
  
  public function compile($compiler)
  {
  
    $compiler
      ->addDebugInfo($this)
      ->write(sprintf("\$context['view']->slots->start('%s');", $this->name))
      ->indent()
      ->subcompile($this->body)
      ->outdent()
      ->write("\$context['view']->slots->stop();")
      ->raw("\n\n");
  
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