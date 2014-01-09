=== Latch - Eleven Paths ===
Author: Eleven Paths
Website: http://www.elevenpaths.com
Stable tag: 1.0.0

Latch WordPress integration proof of concept.

== Description ==

Improve your security using Latch...

= Requires =

* WordPress 3 or higher

* A [registered account in Latch](http://www.elevenpaths.com/)

== Installation ==

1. Login and install the plugin through the 'Plugins' menu in your WordPress
2. Enable the plugin using the 'Activate' link
3. Register your account in Latch website/mobile application
4. Go to Latch plugin settings (under the global 'Settings' menu) and enter your Application ID and Secret Key
5. Using your Latch mobile application, request a new pairing token (expires in one minute)
5. Go to your user profile settings, enter the token and save the changes

== Frequently Asked Questions ==

= What is Latch? = 

...

== Changelog ==

= 1.0.3 =
* Changed the logic not to perform the pairing process when the user is already paired.

= 1.0.2 =
* Updated PHP SDK to handle HTTPS connections.

= 1.0.1 =

* Added Host parameter to the Latch configuration.
* Fixed pairing bugs.

= 1.0.0 =

* First release.