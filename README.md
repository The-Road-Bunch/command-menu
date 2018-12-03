
# theroadbunch/command-menu [![build status](https://scrutinizer-ci.com/g/The-Road-Bunch/command-menu/badges/build.png?b=master)](https://scrutinizer-ci.com/g/The-Road-Bunch/command-menu/)
A simple menu for symfony console commands  
  
[![Latest Stable Version](https://img.shields.io/packagist/v/theroadbunch/command-menu.svg)](https://packagist.org/packages/theroadbunch/command-menu)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Compatible Symfony Version](https://img.shields.io/badge/symfony%2Fconsole-v2.7-ff0000.svg)](https://symfony.com/doc/2.7/components/console.html)
  
_a quick note:_   
This README assumes you have an understanding of creating and running a console command in the symfony ecosystem

### Contents
1. [Release Notes](doc/release.md)
2. [Installation](#installation)
3. [Usage](#usage)  
    a. [Basic Usage](#basic-usage)    
    b. [Selectors](doc/Selectors.md)  
4. [License](LICENSE)

### <a name="installation">Install using composer</a> <sup><small>[[?]](https://getcomposer.org)</a></small></sup>

`composer require theroadbunch/command-menu`

<a name="usage"></a>
### <a name="basic-usage">Basic Usage</a>
Creating, rendering, and using a menu in your symfony console command
```php
<?php

// ...
use RoadBunch\CommandMenu\Menu;
use RoadBunch\CommandMenu\Option;

// ...

public function execute(InputInterface $input, OutputInterface $output)
{      
    // create the menu
    $menu = new Menu($input, $output);
    
    // optional title
    $menu->title('Options');
    
    // add options
    $menu->addOption('add', 'Add User');
    $menu->addOption('delete', 'Delete User');
    $menu->addOption('quit', 'Quit');
    
    // render the menu
    $menu->render();
        
    // prompt the user to make a selection
    $selection = $menu->promptForSelection();
    
    // do work
}
```
Output
```
Options
-------

1 Add User
2 Delete User
3 Quit

Please make a selection:
> |
```
If the user selects `1` then `promptForSelection()` will return `"add"`, `2` will return `"delete"`, and 
`3` will return `"quit"`  
In the event a user selects something other than a given selector, `promptForSelection()` will return `null`
