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
      'Twig_TokenParser_Extends',
      'Twig_TokenParser_Block',
      'Twig_TokenParser_Display',
    );
    
    $new_parsers = array(
      new TokenParser\ExtendsTokenParser(),
      new TokenParser\IncludeTokenParser(),
    );
    
  
    $parsers = parent::getTokenParsers();   

    //filter out unused parsers
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
