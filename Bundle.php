<?php

namespace Bundle\TwigBundle;

use Symfony\Foundation\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;
use Bundle\TwigBundle\DependencyInjection\TwigExtension;

class Bundle extends BaseBundle
{
  public function buildContainer(ContainerInterface $builder)
  {
  
    //$container is a builder 
    Loader::registerExtension(new TwigExtension());

    //set the cache path for the cache loader
    $builder->setParameter('twig.loader.cache.path', $builder->getParameter('kernel.cache_dir').'/twig');
  
    if($debug = $builder->hasParameter('kernel.debug'))
    {
      $builder->setParameter('twig.environment.debug', true);
    }
    
    $dirs = array();
  
    //add extra dirs for loading .twig templates
    foreach($builder->getParameter('templating.loader.filesystem.path') as $dir)
    {
      $dirs[] = str_replace('.php', '.twig', $dir);
    }
    
    $builder->setParameter('twig.loader.filesystem.path', $dirs);
    
    //overwrite the templating engine for enabling helpers
    $builder->setParameter('templating.engine.class', 'Bundle\TwigBundle\Templating\Engine');

    
  }
  
  public function boot(ContainerInterface $container)
  {
  
    //container is a container
    
  }

}