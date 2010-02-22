<?php

namespace Bundle\TwigBundle\DependencyInjection;

use Symfony\Components\DependencyInjection\Loader\LoaderExtension,
    Symfony\Components\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Components\DependencyInjection\BuilderConfiguration;

/**
 * TwigExtension is an extension for the Twig php templating language
 *
 * @package    symfony
 * @subpackage dependency_injection
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class TwigExtension extends LoaderExtension
{
  protected $resources = array(
    'twig' => 'twig.xml',
  );
  
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
    
    $loader = new XmlFileLoader(__DIR__.'/../Resources/config');
    $configuration->merge($loader->load($this->resources['twig']));
    
    if(!empty($config['extension']))
    {
      $configuration->setParameter('twig.loader.extension', $config['extension']);
    }
        
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