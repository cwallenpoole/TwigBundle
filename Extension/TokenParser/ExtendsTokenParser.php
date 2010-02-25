<?Php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\ExtendsNode;

class ExtendsTokenParser extends \Twig_TokenParser
{

  /**
   * Parse th token for the extend tag
   * crate a Extends Node
   */
  public function parse(\Twig_Token $token)
  {
  
    $stream = $this->parser->getStream();
    $parent = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();
    
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);
  
    return new ExtendsNode($token->getLine(), $parent);
  }
  
  /**
   * getTag function.
   * 
   * @return string extends
   */
  public function getTag()
  {
    return 'extends';
  }


}