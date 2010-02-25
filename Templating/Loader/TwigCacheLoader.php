<?php

namespace Bundle\TwigBundle\Templating\Loader;

use Symfony\Components\Templating\Loader\CacheLoader;
use Symfony\Components\Templating\Storage\FileStorage;
use Bundle\TwigBundle\Templating\Storage\TwigStorage;

/**
 * This small wrapper over the cacheloader allows
 * us to pass TwigStorage instances instead of simple
 * file storages
 *
 * @package    twigBundle
 * @subpackage templating
 * @author     Ad van der Veer
 */
class TwigCacheLoader extends CacheLoader
{

  public function load($template, array $options = array())
  {
    $storage = parent::load($template, $options);

    if($storage instanceof FileStorage)
    {
      return new TwigStorage($storage->getContent(), (string) $storage, 'twig');
    }
    
    return $storage;
  }

}
