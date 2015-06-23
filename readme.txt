=== Idle User Logout ===

Contributors: abiralneupane, Sudeep Balchhaudi
Tags: auto, logout, signout, interval, duration, automatic, auto logout, idle time, idle user
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: 1.2

This plugin automatically logs out the user after a period of idle time. The time period can be configured from admin end.

== Description ==
This plugin automatically logs out the user after a period of idle time.

If the user has been inactive for too long, then the user is automatically logged out and redirected to login page.

It tracks the users activity in both the front end and admin end.

You can setup Idle Time from WP Admin > Settings > Idle User Logout

== Installation ==

Install this plugin is very simple:

1.	Upload the plugin's folder to the `/wp-content/plugins/` directory
2.	Activate the plugin through the 'Plugins' menu in WordPress
3.	That's it! Go to Settings > Idle User Logout and configure the field "Auto Logout Duration" as you want.

== Frequently Asked Questions ==

= How do I change the idle time period? =

Go and configure the time period whatever you like from your admin end general settings page.
It's in milliseconds, so 2 seconds is equal to 2000 ms of idle time.

== Screenshots ==

No screenshots!

== Changelog ==
= 1.2 =
* Fix: Plugin activation error resolution

= 1.1 =
* Fix: Bug fixed in Firefox and IE
* Added independent Settings UI

= 1.0 =
* First Version