<?php

namespace Bundle\TwigBundle\Helper;

use Symfony\Components\Templating\Helper\Helper;

/**
 *
 * @package    twigBundle
 * @author     Ad van der Veer
 */
class TwigHelper extends Helper
{

  protected $twig;

  /**
   * To create this helper we
   * require a twig environment
   * 
   * @param \Twig_Environment $twig
   */
  public function __construct(\Twig_Environment $twig)
  {
    $this->twig = $twig;
  }
  
  /**
   * Get the Twig environment used
   * for initialising this helper
   * 
   * @return Twig_Environment
   */
  public function getTwigEnvironment()
  {
    return $this->twig;
  }

  /**
   * Returns the canonical name of this helper.
   *
   * @return string The canonical name
   */
  public function getName()
  {
    return 'twig';
  }
}