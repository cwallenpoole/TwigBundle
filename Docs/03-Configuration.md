## Configuration

There are several ways to easily customize the Twig Bundle. 
For more advanched changes to the logic the Dependency Injection Configuration
should be changed. I wont discuss this here, the Symfony (component) documentation
should be read in this case.

### Changing the .twig extension to something else

This is simple. This can be changed right in your projects configuration:
    
    /* config.yml */
    twig.twig: 
      extension: .php
      
### Changin the template load order

By default the TwigBundle prefers twig template above php templates with the same name.
To change this behaviour you should change the order of the web.templating.loader in
the application configuration. If you followed installation instruction your loader
config should look like this:

    /* config.yml */
    web.templating:
      loader: [twig.loader.cache, templating.loader.filesystem]
  
change it to the following and php templates will be loaded first:

    /* config.yml */
    web.templating:
      loader: [templating.loader.filesystem, twig.loader.cache]