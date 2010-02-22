<?Php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\ExtendsNode;

class ExtendsTokenParser extends \Twig_TokenParser
{

  public function parse(\Twig_Token $token)
  {
  
    $stream = $this->parser->getStream();
    $parent = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();
    
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);
  
    return new ExtendsNode($token->getLine(), $parent);
  }
  
  public function getTag()
  {
    return 'extends';
  }


}