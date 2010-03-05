<?php

namespace Bundle\TwigBundle\DependencyInjection;

use Symfony\Components\DependencyInjection\Loader\LoaderExtension,
    Symfony\Components\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Components\DependencyInjection\BuilderConfiguration,
    Symfony\Components\DependencyInjection\Reference,
    Symfony\Components\DependencyInjection\Definition;

/**
 * TwigExtension is an extension for the Twig php templating language
 *
 * @package    symfony
 * @subpackage dependency_injection
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class TwigExtension extends LoaderExtension
{
  protected $templateDirs;
  protected $resources = array(
    'twig' => 'twig.xml',
  );
  
  
  public function __construct(array $templateDirs)
  {
    $this->templateDirs = $templateDirs;
  }
  
  /**
   * Load the twig configuration, we merge the 
   * developer defined with the default 
   *
   * @return void
   * @author Ad van der Veer
   */
  public function twigLoad($config)
  {
    $configuration = new BuilderConfiguration();
    
    //$configuration is a build configuration
    
    $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
    $configuration->merge($loader->load($this->resources['twig']));
    
    if(!empty($config['extension']))
    {
      $configuration->setParameter('twig.loader.extension', $config['extension']);
    }
    
    //add extra dirs for loading .twig templates
    foreach($this->templateDirs as $dir)
    {
      $dirs[] = str_replace('.php', $configuration->getParameter('twig.loader.extension'), $dir);
    }
    
    $configuration->setParameter('twig.loader.filesystem.path', $dirs);

    return $configuration;
  }
  
  public function sandboxLoad($config)
  {
  
    $configuration = new BuilderConfiguration();
    
    $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
    $configuration->merge($loader->load($this->resources['twig']));

    $tags       = empty($config['tags']) ? array() : $config['tags'];
    $filters    = empty($config['filters']) ? array() : $config['filters'];
    $methods    = empty($config['methods']) ? array() : $config['methods'];
    $properties = empty($config['properties']) ? array() : $config['properties'];
    $global     = empty($config['global']) ? false : $config['global'];

    if(!$configuration->hasDefinition('twig.sandbox.policy'))
    {
      $policy = new Definition('\Twig_Sandbox_SecurityPolicy', array($tags, $filters, $methods, $properties));
      $configuration->setDefinition('twig.sandbox.policy', $policy);
    }
    
    
    if(!$configuration->hasDefinition('twig.sanddbox'))
    {
      $sandbox = new Definition('\Twig_Extension_Sandbox', array(new Reference('twig.sandbox.policy'), $global));
      $configuration->setDefinition('twig.sandbox', $sandbox);
    }

    $twig = $configuration->getDefinition('twig.environment');    
    $twig->addMethodCall('addExtension', array(new Reference('twig.sandbox')));
    
    return $configuration;
  }
  
  /**
   * Returns the Alias for this loader etension
   *
   * @return string the alias
   */
  public function getAlias()
  {
    return 'twig';
  }
  
  /**
   * Returns the namespace to be used for this extension (XML namespace).
   *
   * @return string The XML namespace
   */
  public function getNamespace()
  {
    return 'http://www.symfony-project.org/schema/dic/twig';
  }

  /**
   * Returns the base path for the XSD files.
   *
   * @return string The XSD base path
   */
  public function getXsdValidationBasePath()
  {
    return __DIR__.'/../Resources/config/';
  } 
}