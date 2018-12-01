# theroadbunch/command-menu

## upcoming releases
#### wish list
- ability to set the start number of the incremental selectors
- ability to create and inject a custom incremental selector
- ability to shuffle options

#### v1.0.0 (TBD)
### Changes
- No other notable changes
### Notes
- Update to symfony/console 4.1

#### v0.1.01
### Changes
- [BREAKING] rename Menu::selectFromUserInput() to Menu::promptForSelection

## v0.1.0
NOV 30, 2018 - 11:00 CST
### Changes
- Menu::addOption() now takes an Option instead of name, label, and selector
- Option now accepts a selector and checks for empty names and labels
### Notes
- The current symfony/console version is 2.7, this will be updated and a fork will be made for this version.  
For this reason, this 'release' is not currently suggested for production.

## v0.0.1
NOV 23, 2018 - 22:57 CST
### Changes
- Initial release
### Notes
- The current symfony/console version is 2.7, this will be updated and a fork will be made for this version.  
For this reason, this 'release' is not currently suggested for production.
