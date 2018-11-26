
# theroadbunch/command-menu
A simple menu for symfony console commands  
  
[![build status](https://scrutinizer-ci.com/g/The-Road-Bunch/command-menu/badges/build.png?b=master)](https://scrutinizer-ci.com/g/danmcadams/mandrill-sdk/)
[![scrutinzer quality score](https://scrutinizer-ci.com/g/The-Road-Bunch/command-menu/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/danmcadams/mandrill-sdk/)
![Code Coverage](https://scrutinizer-ci.com/g/The-Road-Bunch/command-menu/badges/coverage.png?b=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
  
_a quick note:_   
This README assumes you have an understanding of creating and running a console command in the symfony ecosystem

### Contents
1. Release Notes (doc/release.md)
2. [Installation](#installation)
3. [Usage](#usage)  
    a. [Basic Usage](#basic-usage)    
    b. [Using Selector Wrappers](#selector-wrappers)  
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

// ...

public function execute(InputInterface $input, OutputInterface $output)
{
    // create the menu
    $menu = new Menu($input, $output);
    
    // optional title
    $menu->title('Options');
    
    // add options Menu::addOption(name, label)
    // options are displayed in the order they are added
    // sequential numbers will be created for selecting options
    $menu->addOption('add', 'Add User');
    $menu->addOption('delete', 'Delete User');
    // add an option with a custom selector
    $menu->addOption('quit', 'Quit', 'Q');        
   
    // render the menu
    $menu->render();
    
    // prompt the user to make a selection
    $selection = $menu->selectFromUserInput('Please make a selection'); 
}   
```
Output
```
Options
-------

1 Add User
2 Delete User
Q Quit

Please make a selection:
> |
```
If the user selects `2` then `selectFromUserInput()` will return `"delete"`.  
If the user selects `Q` then `selectFromUserInput()` will return `"quit"`

### <a name="selector-wrappers">Using Selector Wrappers</a>

Add a wrapper for option selectors
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
(Q) Quit
```

output from the second `$menu->render()`
```
1) Add User
2) Delete User
Q) Quit
```
