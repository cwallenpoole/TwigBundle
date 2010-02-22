<?php

namespace Bundle\TwigBundle;

use Symfony\Foundation\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;
use Bundle\TwigBundle\DependencyInjection\TwigExtension;

class Bundle extends BaseBundle
{
  public function buildContainer(ContainerInterface $container)
  {
    Loader::registerExtension(new TwigExtension());

    $container->setParameter('twig.loader.cache.path', $container->getParameter('kernel.cache_dir').'/twig');
    
    if($debug = $container->getParameter('kernel.debug'))
    {
      $container->setParameter('twig.environment.debug', true);
    }
    
    $dirs = array();
  
    foreach($container->getParameter('templating.loader.filesystem.path') as $dir)
    {
      $dirs[] = str_replace('.php', '.twig', $dir);
    }
    
    $container->setParameter('twig.loader.filesystem.path', $dirs);
    
  }
  

}