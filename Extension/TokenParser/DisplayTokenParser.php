<?php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\DisplayNode;

class DisplayTokenParser extends \Twig_TokenParser_Display
{

  public function parse(\Twig_Token $token)
  {
    $lineno = $token->getLine();
    $stream = $this->parser->getStream();
    $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
    
    if ($stream->test(\Twig_Token::BLOCK_END_TYPE))
    {
      $stream->next();

      $default = $this->parser->subparse(array($this, 'decideDisplayEnd'), true);
      
      if ($stream->test(\Twig_Token::NAME_TYPE))
      {
        $value = $stream->next()->getValue();

        if ($value != $name)
        {
          throw new Twig_SyntaxError(sprintf("Expected enddisplay for display '$name' (but %s given)", $value), $lineno);
        }
      }
    }
    else
    {
    
      $default = new \Twig_NodeList(array(
        new \Twig_Node_Print($this->parser->getExpressionParser()->parseExpression(), $lineno),
      ));
    }
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);
    
    return new DisplayNode($name, $default, $lineno, null, $this->getTag());
    
  }
  
  public function decideDisplayEnd($token)
  {
    return $token->test('enddisplay');
  }

}