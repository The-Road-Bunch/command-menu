# <a name="menu-selectors">Menu Selectors</a>

Selectors are used to compare user input with a selected menu option. When calling `Menu::select($selection)` or `Menu::promptForSelection()` the user input will be checked against the selectors.  
In the render below you can see that `1`, `2`, and `3` are the selectors:
```
1 Add User
2 Delete User
3 Quit
```
Selectors, by default, are auto-generated integers starting with `1`. If you do not want to use the provided
selectors, you will have to provide a your own for each option you add.

### Custom Menu Selectors
```php
public function execute(InputInterface $input, OutputInterface $output)
{
    $menu = new Menu($input, $output);
    
    $menu->addOption('new', 'New User');
    $menu->addOption('delete', 'Delete User');
    // use a custom selector for Quit, so it's always the same key
    $menu->addOption('quit', 'Quit', 'q');
    
    $menu->render();
}
```
Output
```
1 New User
2 Delete User
q Quit
```
_**note:**_ custom selectors are case insensitive, so providing `Menu::select()` with `"q"` or `"Q"` will produce the same results

### <a name="selector-wrappers">Selector Wrappers</a>

By default, the only thing separating the option labels from the selectors are a space. 
You can change this by adding a custom selector wrapper. There are several provided wrappers for you to use, but if
you'd like to build your own, just make sure it implements `WrapperInterface` or use `new Wrapper()` 
when calling `Menu::setSelectorWrapper()`

Example
```php
<?php

use RoadBunch\CommandMenu\Menu;
use RoadBunch\Wrapper\ParenthesisWrapper;
use RoadBunch\Wrapper\Wrapper;
// ..

public function execute(InputInterface $input, OutputInterface $output)
{
    $menu = new Menu($input, $output);
    
    // add options
    
    // add a wrapper from the library
    $menu->setSelectorWrapper(new ParenthesisWrapper());
    $menu->render();
    
    // add a custom wrapper
    $menu->setSelectorWrapper(new Wrapper('', ')'));
    $menu->render();
}
```
output from the first `$menu->render()`
```
(1) Add User
(2) Delete User
(3) Quit
```

output from the second `$menu->render()`
```
1) Add User
2) Delete User
3) Quit
```
