<?Php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\SetSlotNode;

class SetSlotTokenParser extends \Twig_TokenParser
{

  public function parse(\Twig_Token $token)
  {

    /**

BLOCK_START_TYPE()
NAME_TYPE(setslot)
NAME_TYPE(test)
NAME_TYPE(default)
STRING_TYPE(hey)
BLOCK_END_TYPE()

    
    
    */


    $lineno = $token->getLine(); //line where this token is found
    $stream = $this->parser->getStream(); //complete stream of token


    //stream starts after opening bracket we then expect a name
    $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
    $default = null;
    
    if ($stream->test(\Twig_Token::STRING_TYPE))
    {
      $default = $stream->next()->getValue();
    }
    
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);

    return new SetSlotNode($name, $lineno, $default);
  }
  
  
  public function getTag()
  {
    return 'setslot';
  }


}