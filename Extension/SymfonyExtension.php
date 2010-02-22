<?php

namespace Bundle\TwigBundle\Extension;

class SymfonyExtension extends \Twig_Extension_Core
{

  /**
   * Returns the token parser instance to add to the existing list.
   *
   * @return array An array of Twig_TokenParser instances
   */
  public function getTokenParsers()
  {
  
    $removed_parsers = array(
      'Twig_TokenParser_Extends'
    );
    
    $new_parsers = array(
      new TokenParser\SlotTokenParser(),
      new TokenParser\SetSlotTokenParser(),
      new TokenParser\ExtendsTokenParser(),
    );
    
  
    $parsers = parent::getTokenParsers();   

    //filter out some unused parsers
    foreach($parsers as $key => $parser)
    {
      if(in_array(get_class($parser), $removed_parsers))
      {
        unset($parsers[$key]);
      }
    };

    return array_merge($parsers, $new_parsers);
  }

}
