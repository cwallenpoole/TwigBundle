<?php

namespace Bundle\TwigBundle\Templating\Storage;

use  Symfony\Components\Templating\Storage\FileStorage;

/**
 * This Representas a twig storage, a rather special storage
 * as it keeps the template content as a string as well as the
 * location of the original file it was taken from. 
 * 
 * @extends FileStorage
 */
class TwigStorage extends FileStorage
{

  protected $content;

  public function __construct($content, $path = null, $renderer = null)
  {
    $this->template = $path;
    $this->content = $content;
    $this->renderer = $renderer;
  }
  
  public function getContent()
  {
    return $this->content;
  }
  
  /**
   * Returns wether this storage is linked to a file
   * 
   * @access public
   * @return void
   */
  public function isFiled()
  {
    return !empty($this->template);
  }

}