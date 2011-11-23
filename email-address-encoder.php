<?php
/*
Plugin Name: Email Address Encoder
Plugin URI: http://wordpress.org/extend/plugins/email-address-encoder/
Description: A lightweight plugin to protect email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities.
Version: 1.0.1
Author: Till Krüss
Author URI: http://tillkruess.com/
License: GPLv3
*/

/**
 * Copyright 2011 Till Krüss  (www.tillkruess.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Email Address Encoder
 * @copyright 2011 Till Krüss
 */

/**
 * Register filters to encode exposed email addresses in
 * posts, pages, comments & widgets.
 */
foreach (array('the_content', 'the_excerpt', 'widget_text', 'comment_text', 'comment_excerpt') as $filter) {
	add_filter($filter, 'eae_encode_emails', 1000);
}

/**
 * WordPress filter callback function. Searches for plain
 * email addresses in given $string and encodes them with
 * the help of eae_encode_str().
 * 
 * Regular expression is based on based on John Gruber's Markdown.
 * http://daringfireball.net/projects/markdown/
 * 
 * @uses eae_encode_str()
 * 
 * @param string $string Text with email addresses to encode
 * @return string $string Given text with encoded email addresses
 */
function eae_encode_emails($string) {
	return preg_replace_callback('
		{
			(?:mailto:)?
			(?:
				[-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+
			|
				".*?"
			)
			\@
			(?:
				[-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+
			|
				\[[\d.a-fA-F:]+\]
			)
		}xi',
		create_function(
            '$matches',
            'return eae_encode_str($matches[0]);'
        ),
		$string
	);
}

/**
 * Encodes each character of the given string as either a decimal
 * or hexadecimal entity, in the hopes of foiling most email address
 * harvesting bots.
 *
 * Based on Michel Fortin's PHP Markdown:
 *   http://michelf.com/projects/php-markdown/
 * Which is based on John Gruber's original Markdown:
 *   http://daringfireball.net/projects/markdown/
 * Whose code is based on a filter by Matthew Wickline, posted to
 * the BBEdit-Talk with some optimizations by Milian Wolff.
 *
 * @param string $string Text with email addresses to encode
 * @return string $string Given text with encoded email addresses
 */
function eae_encode_str($string) {

	$chars = str_split($string);
	$seed = (int) abs(crc32($string) / strlen($string));

	foreach ($chars as $key => $char) {

		$ord = ord($char);

		if ($ord < 128) { // ignore non-ascii chars

			$r = ($seed * (1 + $key)) % 100; // pseudo "random function"

			if ($r > 80 && $char != '@') ; // plain character (not encoded)
			else if ($r < 45) $chars[$key] = '&#x'.dechex($ord).';'; // hexadecimal
			else $chars[$key] = '&#'.$ord.';'; // decimal (ascii)

		}

	}

	return implode('', $chars);

}
