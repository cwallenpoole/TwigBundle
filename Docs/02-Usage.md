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

### Blocks and Displays

The Block and Display tags have been emulated to Symfony with this Bundle and work together seamleassly with Symfony slots. But if you know your way around the Twig syntax you will run into some unexpected behaviour. 
The Reasoning behind this is explained in the FAQ. in short: The block tag can no longer be used to define default content,  display tags are the preferred way to 'define' a block;

Blocks are rougly equilavent to Symfony Slots and if you look behind the scene the block tags are merely a facade to the Symfony slot syntax. Using Slots directly using the method
above is therefore faster by a small margine but somewhat less readable. The example below shows a typical parent and child template,
    /* layout.twig (parent) */
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{% display title %}default{% enddisplay %}</title>
      </head>
      <body>
        
        <div id="content">
          {% display _content %}{% enddisplay %}
        </div>
        
        <div id="footer">
          {% display footer "default sidebar" %}
        </div>
        
      </body>
    </html>


    /* Hello/index.twig (child) */
    {% extends "HelloBundle::layout" %}
    
    Howdie {{ name }}
    
    {% block title "Overwritten Title" %}

You'll notice that 3 blocks have been defined with the display tag. With _content being a special system block,
Only the title block has been overwritte which means that for the footer block the default content is used; "default sidebar".

### Inclusion

for including a template you may use the Twig Include tag like this

    {% include "HelloBundle:Hello:text" with ['name': 'Foo Bar'] %}
