## Installation

Download the git repository in the /src folder of your symfony root directory

    cd /src/Bundle@
    git clone git://github.com/advanderveer/TwigBundle.git@

For the TwigBundle to work we will also need twig installed and the PEAR prefix loaded. 
You may download the Twig source in any directory you like but for this tutorial we will 
go by convention and place it into a twig (lowercase) folder of the /src/vendor directory 
of our Symfony Project.

    cd /src/vendor@
    git clone git://github.com/fabpot/Twig.git twig@

New now need to configure the autloading of our Symofony application to complete the installation. 
Thereopen up the applications kernel file in your application folder and add the necessary TwigBundle 
line to the RegisterBundles function:

    public function registerBundles()
    {
      return array(
    
        //Core bundles and your application bundles are lined up here
    
        new Bundle\TwigBundle\Bundle(),
      );
    }

The Twig "namespace" should also be registered in the autoloader. 
For this step open up the autoload.php in your /src folder. 
Because twig is a php version < 5.3 we add the Twig line to 
the RefisterPrefix function call like this:

    $loader->registerPrefixes(array(
      //Default prefixes like zend and swift are here
      'Twig_'  => __DIR__.'/vendor/twig/lib'
    ));

Finally we need to enable the twig bundle in our applications 
config.yml for the depency injection container to create it:

    /* config.yml */
    twig.twig: ~

We also need to enable the template loader. There is a cached loader available for producten 
and a non cached for development. Do not forget to enable the standard 
template.loader.filesystem if you want to use the normal .php templates.

    /* config_dev.ytml */

    //for development we use the twig.loader
    web.templating:
      loader: [twig.loader, templating.loader.filesystem]

    /*  config.yml */

    //for producten we use the cached twig.loader.cache
    web.templating:
      loader: [twig.loader.cache, templating.loader.filesystem]
