## Usage

The usage of the TwigBundle has been made as transparant as possible. From the controller is works exacly like you are used to:

    $this->render('HelloBundle:Hello:index', array('name' => $name));

Now for the view you can decide to make a php template as you are used to by placing a index.php 
file into the /Resources/views/%controller%/ folder. Or you may place a index.twig file in the same directory. 
In this file the Twig syntax as described in the "official documentation":http://www.twig-project.org/documentation is available.

    {% for i in 0..10 %}
    
      <h1>helloo {{ name|upper }}</h1>
    
    {% endfor %}

The TwigBundle by default makes sure that .twig files are favoured above .php templates with the same name.
If you dislike this behaviour please read the Configuration Chapter.

For integrating the full Symfony templating experience into twig some extra's have been added in the form of a Twig extension. 

### Extending

Extending teplate is working as aspected with the twig Extend tag:

    {% extends "HelloBundle::layout" %}
    
Which is equivalent to the following php:

    <?php $view->extend('HelloBundle::layout') ?>


### Helpers

Helpers are available through the special view object. Any call you can execute on normal
symfony helpers can be called in twig. Take a look at the following example:
  
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

The Block and Display tags have been emulated to Symfony with this Bundle and work together seamleassly with Symfony slots. 
But if you know your way around the Twig syntax you may run into some unexpected trouble. 
In short: The block tag can no longer be used to define default content,  display tags are the preferred way to 'define' a block.
The Reasoning behind this is explained in the FAQ

Blocks are rougly equilavent to Symfony Slots and if you look behind the scene the block tags are merely a facade to the Symfony slot syntax. Using Slots directly using the method
above is therefore faster by a small margine but somewhat less readable. The example below shows a typical parent and child template with blocks,
    
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
        
        <div id="sidebar">
          {% display footer "default sidebar" %}
        </div>
        
      </body>
    </html>


    /* Hello/index.twig (child) */
    {% extends "HelloBundle::layout" %}
    
    Howdie {{ name }}
    
    {% block title "Overwritten Title" %}

You'll notice that 3 blocks have been defined with the display tag. With _content being a special system block,
Only the title block has been overwritten which means that for the footer block the default content is used; "default sidebar".

### Inclusion

for including a template you may use the Twig Include tag like this

    {% include "HelloBundle:Hello:text" with ['name': 'Foo Bar'] %}
    
### Sandboxing

Twig sandboxing also works as you may expect:

    {% include "HelloBundle:Hello:text" sandboxed with ['name': 'Foo Bar'] %}

The TwigBundle also has the added bonus that the sandbox policy can be described in your applications configuration
file under the twig.sandbox group. 

    /* config.yml */
    twig.sandbox:
      global: false                       #will automaticlu apply this policy to every rendered twig template
      tags: [block, include, display]     # whitelist of tags, filter, methods and properties
      filters: [upper]
      methods: {Article: created_at}
      properties: {Article: body}
      
NOTE: disabling sandboxing is simply done by removing the twig.sandbox entry from you config file.

