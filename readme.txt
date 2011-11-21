=== Email Address Encoder ===
Contributors: tillkruess
Tags: antispam, anti spam, spam, email, e-mail, mail, spider, crawler, harvester, robots, spambot, block, obfuscate, obfuscation, encode, encoder, encoding, encrypt, encryption, protect, protection
Requires at least: 2.0
Tested up to: 3.3
Stable tag: 1.0

A lightweight plugin to protect plain email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities.

== Description ==

A lightweight plugin to protect plain email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the content of posts, pages, comments and text widgets. No UI, no shortcode, no JavaScript — just simple spam protection.


== Usage ==

To manually encode an single email address use the `eae_encode_str()` function: `<?php echo eae_encode_str('foobar@example.com'); ?>`

To manually encode all email addresses in a string pass it through the `eae_encode_emails()` function: `<?php echo eae_encode_emails($text); ?>`


== Installation ==

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Done. This plugin has no user interface or configuration options.


== Changelog ==

= 1.0 =

* Initial release
