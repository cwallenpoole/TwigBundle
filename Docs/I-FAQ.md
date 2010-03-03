## Frequently Asked Questions

### Why doesn't the block allows for defining Default content like im used to with standalone Twig?

This has to do mainly with the fact that this Bundle has as one of its primairy objectives to provide a transparent way for normal PHP templates and Twig templates
to work together seamlessly. 

Twig Templates are compiled down to classes, this has the main benefit that php takes over inheritance issues. It also mean that the resulting php knows which template extends
which template. The Normal Symfony PHP template do not share this knowledge because they are already written as php and executed in a sequential matter. Thi means the template 
that extends another template (the layout) doest not know which blocks (or slots) will have to be filled in in the parent. Compiled Twig templates do know this because the php 
class structure can tell it this information.

In Twig this means that defining and filling slots can be done with one single Block tag. And Twig can determine by looking at the template parents and children wether the
blocks content needs to be used as a default value and output it or to fill a parent slot and output it there.

Symfony Cannot make this discision because it knows nothing about the parent temlate. therefore defining a block  and filling it is done with distinct tags: 'Display' is used 
for defining a block ( like $view->slots->output() ) and the 'Block' tag is used to fill these parent slots ( like $view->slots->set() ).