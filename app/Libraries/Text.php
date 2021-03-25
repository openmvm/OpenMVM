<?php

namespace App\Libraries;

class Text
{
	public function startsWith( $haystack, $needle ) {
		$length = strlen($needle);

		return substr($haystack, 0, $length) === $needle;
	}

	public function endsWith( $haystack, $needle ) {
		$length = strlen($needle);

		if(!$length) {
	    return true;
		}

		return substr($haystack, -$length) === $needle;
	}

  public function slugify($text)
  {
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
  }
}