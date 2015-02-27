<?php
/*
Plugin Name: Automatic Smileys with icomoon font
Plugin URI: http://www.fruityfred.com/ff-auto-smiley-font/
Version: 1.0.0
Author: FruityFred
Description: Transforms the main emoticon codes into font icons: <i class="..."></i>
Text Domain: ff-auto-smiley-font
Domain Path: /languages/
*/


add_action( 'plugins_loaded', 'ff_smileys_load_textdomain' );
function ff_smileys_load_textdomain() {
  load_plugin_textdomain('ff-auto-smiley-font', false, dirname( plugin_basename( __FILE__ ) ) . '/languages'); 
}


// Add our plugin as a content filter.
add_filter('comment_text', array('ff_smileys', 'transform'));
add_filter('the_content', array('ff_smileys', 'transform'));


class ff_smileys {
	
	private static $smileysRegExp = array(
		'>:\-?\)'   => 'evil',
		':\-?\)' => 'smile',
		':\-?D'  => 'happy',
		':\-?\('  => 'sad',
		":'\("    => 'crying',
		';\-?\)'  => 'wink',
		':\-?p'  => 'tongue',
		'<3'     => 'heart',
		':\-?\|' => 'neutral',
		':\-/'  => 'wondering',
		':\-?O'  => 'shocked',
		':\-?[\$s]' => 'confused',
		'8\-?[\)D]' => 'cool'
	);
	
	public static function transform($text) {
		$count = 0;
		foreach (self::$smileysRegExp as $code => $name) {
			$text = preg_replace(
				'#(\W)(' . $code . ')([^"])#i',
				'$1<i title="' . __(self::$smileysRegExp[$code], 'ff-auto-smiley-font') . ' $2" class="icon-' . self::$smileysRegExp[$code] . '"></i>$3',
				$text
			);
			$text = preg_replace(
				'#(\W)(' . $code . ')$#i',
				'$1<i title="' . __(self::$smileysRegExp[$code], 'ff-auto-smiley-font') . ' $2" class="icon-' . self::$smileysRegExp[$code] . '"></i>',
				$text
			);
		}
		return $text;
	}
}

wp_register_style('ff-auto-smiley-font', plugins_url('style.css', __FILE__ ));
wp_enqueue_style('ff-auto-smiley-font');
