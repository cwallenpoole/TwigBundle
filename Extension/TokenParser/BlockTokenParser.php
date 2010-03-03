<?php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\BlockNode;

class BlockTokenParser extends \Twig_TokenParser_Block
{

  public function parse(\Twig_Token $token)
  {
    $lineno = $token->getLine();
    $stream = $this->parser->getStream();
    $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
    
    if ($stream->test(\Twig_Token::BLOCK_END_TYPE))
    {
      $stream->next();

      $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
      if ($stream->test(\Twig_Token::NAME_TYPE))
      {
        $value = $stream->next()->getValue();

        if ($value != $name)
        {
          throw new Twig_SyntaxError(sprintf("Expected endblock for block '$name' (but %s given)", $value), $lineno);
        }
      }
    }
    else
    {
      $body = new \Twig_NodeList(array(
        new \Twig_Node_Print($this->parser->getExpressionParser()->parseExpression(), $lineno),
      ));
    }
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);
    
    return new BlockNode($name, $body, $lineno, null, $this->getTag());
    
  }

}