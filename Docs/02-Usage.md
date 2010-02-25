## Usage

The usage of the TwigBundle has been made as transparant as possible. From the controller is works exacly like you are used to:

    $this->render('HelloBundle:Hello:index', array('name' => $name));

Now for the view you can decide to make a php template as you are used to by placing a index.php file into the /Resources/views/%controller%/ folder. Or you may place a index.twig file in the same directory. In this file the Twig syntax as described in the "official documentation":http://www.twig-project.org/documentation is available.

    {% for i in 0..10 %}
    
      <h1>helloo {{ name|upper }}</h1>
    
    {% endfor %}

p. The TwigBundle by default makes that .twig files are favoured above .php templates with the same name.

For integrating the full Symfony templating experience into twig some extra's have been added in the form of a Twig extension. But because a number Twig features are also available in the Symfony template engine some of the default Twig Tags have been disabled.

### Extending

Extending is working as aspected with the twig Extend tag:

    {% extends "HelloBundle::layout" %}
    
In equivalent to the following php:

    <?php $view->extend('HelloBundle::layout') ?>


### Helpers

Helpers are available through the special view object. Take a look at the following example
  
    <html>
      <head>
        <title>{{ view.slots.get('title', 'Default Title') }}</title>
      <?head>
      <body>
        
        {{ view.slots.set('title', 'Hello World') }}
        
        {{ view.slots.start('title') }}
        
           Hello large world
        
        {{ view.slots.stop(); }}
      </body>
    </html
    
Is the same as the following php:

    <html>
      <head>
        <title><?php echo $view->slots->get('title', 'Default Title') ?></title>
      </head>
      <body>
        <?php $view->slots->set('title', 'Hello World'); ?>
        
        <?php $view->slots->start('title'); ?>
        
           Hello large world
           
        <?php $view->slots->stop(); ?>
        
      </body>
    </html>

NOTE: Twig "blocks" are disabled in favor of slots (see the example above)

### Inclusion

for including a template you may use the Twig Include tag like this

    {% include "HelloBundle:Hello:text" with ['name': 'Foo Bar'] %}
