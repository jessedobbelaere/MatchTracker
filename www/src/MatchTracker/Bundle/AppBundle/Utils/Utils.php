<?php

namespace MatchTracker\Bundle\AppBundle\Utils;


/**
 *
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */
class Utils {

	/**
	 * Canonicalize a string
	 *
	 * @param $str
	 * @param string $separator
	 * @param bool $lowercase
	 * @return string
	 */
	static function canonicalize($str, $separator = '-', $lowercase = TRUE) {
		if ($separator == 'dash')
		{
			$separator = '-';
		}
		else if ($separator == 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator);

		// <-- Some known special characters are added
		$trans = array(
			'[àáâãå]+'                => 'a',
			'[æ]+'                    => 'ae',
			'[ä]+'                    => 'ae',
			'[ç]+'                    => 'c',
			'[èéêë]+'                => 'e',
			'[ìíîï]+'                => 'i',
			'[ðòóôõ]+'                => 'o',
			'[ö]+'                    => 'oe',
			'[ø]+'                    => 'o',
			'[ùúû]+'                => 'u',
			'[ü]+'                    => 'ue',
			'[ß]+'                    => 'ss',
			'&.+?;'                 => '',
			'[^a-z0-9 _-]'          => '',
			'\s+'                   => $separator,
			'('.$q_separator.')+'   => $separator
		);

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{ // <-- Pattern strings are treaded as UTF-8 ('u' added).
			$str = preg_replace("#".$key."#ui", $val, $str);
		}

		if ($lowercase === TRUE)
		{ // <-- Added charset
			$str = mb_strtolower($str,'UTF-8');
		}

		return trim($str, $separator);
	}
}
