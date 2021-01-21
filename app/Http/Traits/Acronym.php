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
    public function generateCollege($key, $as_space = array('_', 'of', 'and'))
    {

		$str = str_replace($as_space, '-', trim($key));
		$str1 = str_replace('---', '-', trim($str));
	    $ret = '';
	    foreach (explode('-', $str1) as $word) {
			$ret .= strtoupper($word[0]);
	    }
		if($ret == "IT"){
			$ret = "ITECH";
		}
	    return $ret;
	}
	
    public function generateCourse($key, $as_space = array(' of', ' in', ' and', ' Major'))
    {

		$str = str_replace($as_space, '-', trim($key));
		$space = array('--', '- ', ' ');
		$str1 = str_replace($space, '-', trim($str));
	    $ret = '';
	    foreach (explode('-', $str1) as $word) {
			$ret .= strtoupper($word[0]);
		}
		if($ret == "BSE"){
			$ret = "BSENTREP";
		}
	    return $ret;
    }
}
