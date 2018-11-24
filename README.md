# theroadbunch/command-menu
A Simple Menu For Symfony Console Commands

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

### Contents
1. Release Notes
2. [Installation](#installation)
3. [Basic Usage](#basic-usage)  
4. [License](LICENSE)

### <a name="installation">Install using composer</a> <sup><small>[[?]](https://getcomposer.org)</a></small></sup>

`composer require theroadbunch/command-menu`

### <a name="basic-usage">Basic Usage</a>
```php
<?php

use RoadBunch\CommandMenu\Menu;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class YourCommand extends Command
{
    // ...
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $menu = new Menu($output);
        
        $menu->addOption('add', 'Add');
        $menu->addOption('delete', 'Delete');
        $menu->addOption('quit', 'Quit');
        
        $menu->render();      
    }
    
    // ...
}
```
// output
```
1 Add
2 Delete
3 Quit
```

// @todo - continue working on this README
