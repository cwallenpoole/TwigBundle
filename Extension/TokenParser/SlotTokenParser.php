<?Php

namespace Bundle\TwigBundle\Extension\TokenParser;

use Bundle\TwigBundle\Extension\Node\SymfonySlotNode;

class SlotTokenParser extends \Twig_TokenParser
{

  public function parse(\Twig_Token $token)
  {

    /**

        //define a slot
        $view->slots->output('title', 'Default Title')

        //fill a slot
        1. <?php $view->slots->set('title', 'Hello World app') ?>


        2. $view->slots->start('title') ?>

            Some large amount of HTML
          
          <?php $view->slots->stop() ?>
    
    
    */


    $lineno = $token->getLine(); //line where this token is found
    $stream = $this->parser->getStream(); //complete stream of token


    //stream starts after opening bracket we then expect a name
    $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
    
    
    if ($this->parser->hasBlock($name))
    {
      throw new \Twig_SyntaxError("The slot '$name' has already been defined", $lineno);
    }
    $this->parser->setCurrentBlock($name);


    //if we then get a closing bracket we expect a end slot somehwere
    if ($stream->test(\Twig_Token::BLOCK_END_TYPE))
    {
    
      $stream->next();
    
      //get the content definition of the slot
      $body = $this->parser->subparse(array($this, 'decideSlotEnd'), true);
    
      //test wether the endslot is for this slot name
      if ($stream->test(\Twig_Token::NAME_TYPE))
      {
        $value = $stream->next()->getValue();
        if ($value != $name)
        {
          throw new \Twig_SyntaxError(sprintf("Expected endslot for slot '$name' (but %s given)", $value), $lineno);
        }
      }    
    
    }
    
    $stream->expect(\Twig_Token::BLOCK_END_TYPE);

    return new SymfonySlotNode($name, $body, $lineno);
  }
  

  public function decideSlotEnd($token)
  {
    return $token->test('endslot');
  }

  
  public function getTag()
  {
    return 'slot';
  }


}