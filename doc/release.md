# theroadbunch/command-menu

## upcoming releases
#### wish list
- ability to set the start number of the incremental selectors
- ability to create and inject a custom incremental selector
- ability to shuffle options

#### v0.2.0
Changes  
- `Menu::selectFromUserInput()` has been renamed to `Menu::promptForSelection()`
- revert `Menu::addOption()` now takes individual parameters instead of the `Option` object. Currently we're returning 
`(string) name` and it makes more sense to add an option with strings. This may change again in the future  
- add `Menu::renderWithPrompt()` which calls `Menu::render()` and then `Menu::promptForSelection()`
  
Fixes  

- Duplicator option selectors are no longer allowed
  
Notes  

- The current symfony/console version is 2.7, this 'release' is not currently suggested for production, but is fine
if you haven't quite upgraded yet.

## v0.1.0
NOV 30, 2018 - 11:00 CST
### Changes
- `Menu::addOption()` now takes an Option instead of name, label, and selector
- Option now accepts a selector and checks for empty names and labels
### Notes
- The current symfony/console version is 2.7, this 'release' is not currently suggested for production, but is fine
if you haven't quite upgraded yet.

## v0.0.1
NOV 23, 2018 - 22:57 CST
### Changes
- Initial release
### Notes
- The current symfony/console version is 2.7. This will be updated and a tag will be made for this version.  
For this reason, this 'release' is not currently suggested for production.
