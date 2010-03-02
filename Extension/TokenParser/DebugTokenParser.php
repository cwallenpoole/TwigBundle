<?php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\DebugNode;


class DebugTokenParser extends \Twig_TokenParser_Debug
{

  public function parse(\Twig_Token $token)
  {
    $lineno = $token->getLine();

    $expr = null;
    if (!$this->parser->getStream()->test(\Twig_Token::BLOCK_END_TYPE))
    {
      $expr = $this->parser->getExpressionParser()->parseExpression();
    }
    $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

    return new DebugNode($expr, $lineno, $this->getTag());
    
  }

}