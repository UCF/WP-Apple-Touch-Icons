# WP Apple Touch Icons Plugin #

Provides the ability to add a site-wide Apple Touch Icon. This icon will be used as the thumbnail image when a page is bookmarked on an Apple device. Individual page icon can also be set.


## Description ##

Provides the ability to add a site-wide Apple Touch Icon. This icon will be used as the thumbnail image when a page is bookmarked on an Apple device. Individual page icon can also be set.


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/WP-Apple-Touch-Icons/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.


## Changelog ##

### 1.0.2 ###
Enhancements:
* Updated packages; added template and linter config files; upgraded gulpfile.

Bug Fixes:
* Fixed notice when displaying empty `img` tag in the Apple Touch Icons metabox when no image has been selected.

### 1.0.1 ###
Bug Fixes:
* Cleaned up notice that was being thrown when the global $post was accessed on pages where it doesn't get set.

### 1.0.0 ###

* Initial Release

## Upgrade Notice ##

n/a


## Installation Requirements ##

None


## Development & Contributing ##

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.

