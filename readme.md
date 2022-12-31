## Social Media Station
Contributors:      bahson
Donate link:       https://flaircore.com/flair-core/paypal_payment
Tags:              social media
Description:       Manage social media posts on a single platform.
Tested up to:      6.1
Stable tag:        0.1.0
Requires PHP:      7.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Schedule posts to multiple social media platforms.

|Schedule post|Config Form|
|-|-|
|![Schedule post](/assets/screenshot-1.png)|![Config Form](/assets/screenshot-2.png)|

### Description

This plugin allows you to schedule social media posts from within your WordPress website/app.

### Installation

1.  Install via the Wordpress plugin repository or download and place in /wp-content/plugins directory
2.  Activate the plugin through the \'Plugins\' menu in WordPress
3.  See this plugin's configuration section.

### Scheduling content
To add Scheduled content/post , under `/wp-admin/edit.php?post_type=social_media` the description will be included in the
about status text as well as any media, the link added will be posted as the 1st reply to the post.
Remember to configure your application/module as outlined below.

### Configuration
1. Under Plugin name, click the settings link to reveal the configuration form.
For twitter, you will be required to login and create an account @ https://developer.twitter.com/en/docs/platform-overview

After that create an app and note the **Consumer Keys:** (key and secret) and the
**Authentication Tokens:** (Token and Secret).


### Screenshots ==

1. Social media post scheduling form.
2. Social media station configuration form.

### Changelog

### 0.1.0
* Initial release, includes a configuration form and can post to twitter.

