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
    $parsers = parent::getTokenParsers();
    
    //$parsers[] = new TokenParser\SymfonySlotTokenParser();
    
    return $parsers;
  }

}
