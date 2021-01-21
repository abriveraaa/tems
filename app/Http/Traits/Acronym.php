<?php

namespace App\Http\Traits;

trait Acronym
{
    /**
     * Generate initials from a key
     *
     * @param string $key
     * @return string
     */
    public function generate($str, $as_space = array('-', 'of', 'and'))
    {
       	$str = str_replace($as_space, ' ', trim($str));
	    $ret = '';
	    foreach (explode(' ', $str) as $word) {
	        $ret .= strtoupper($word[0]);
	    }
	    return $ret;
    }

    protected function makeInitialsFromSingleWord(string $key) : string
	{
	    preg_match_all('#([A-Z]+)#', $key, $capitals);
	    if (count($capitals[1]) >= 2) {
	        return substr(implode('', $capitals[1]), 0, 2);
	    }
	    return strtoupper(substr($key, 0, 2));
	}
}
