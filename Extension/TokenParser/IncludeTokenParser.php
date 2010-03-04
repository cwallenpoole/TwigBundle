<?php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\IncludeNode;


class IncludeTokenParser extends \Twig_TokenParser_Include
{

  public function parse(\Twig_Token $token)
  {
    $node = parent::parse($token);
    
    if($node instanceof \Twig_Node)
    {
    
      return new IncludeNode($node->getIncludedFile(), $token->getLine(),$node->isSandboxed(), $node->getVariables(), $this->getTag());
    }
    
    return $node;
    
  }

}