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
    public function generateCollege($key, $as_space = array('_', 'of', 'and', 'the', ','))
    {
		$str = str_replace($as_space, '-', trim($key));
		$space = array('-----','----','---','--','-','- ', ' ');
		$str1 = str_replace($space, '-', trim($str));
	    $ret = '';
	    foreach (explode('-', $str1) as $word) {
			$ret .= strtoupper($word[0]);
		}
		// dd($ret);
		if($key == "College_of_Education"){
			$ret = "COED";
		}elseif($key == "College_of_Communication"){
			$ret = "COC";
		}

		if($ret == "IT"){
			$ret = "ITECH";
		}
	    return $ret;
	}
	
    public function generateCourse($key, $college, $as_space = array(' of', ' in', ' and', ' Major', ' major'))
    {
    	if($key == "Bachelor of Science in Computer Engineering"){
			return $ret = "BSCOE";
		}elseif($key == "Bachelor of Science in Electronics Engineering"){
			return $ret = "BSECE";
		}elseif($key == "Bachelor of Science in Physics"){
			return $ret = "BSPHY";
		}elseif($key == "Bachelor of Science in Transportation Management"){
			return $ret = "BSTRM";
		}elseif($key == "Bachelor of Arts in Philosophy"){
			return $key = "AB-PHILO";
		}

		$str = str_replace($as_space, '-', trim($key));
		$space = array('--', '- ', ' ');
		$str1 = str_replace($space, '-', trim($str));
		$ret = '';
	    foreach (explode('-', $str1) as $word) {
			$ret .= strtoupper($word[0]);
		}
        
		$result = substr($ret, 0, 2);
		$result4 = substr($ret, 0, 4);
		$result5 = substr($ret, 0, 5);

		$remain = substr($ret, 2); 
		$remain4 = substr($ret, 4); 
		$remain5 = substr($ret, 5); 

		if($result5 == "BBTLE" && $college == "COED"){
			$ret = "BBTLED".$remain5;
		}elseif($result4 == "BTVE" && $college == "COED"){
			$ret = "BTVED".$remain4;
		}elseif($result == "BA" && $college == "CAL"){
			$ret = "AB".$remain;
		}

		if($ret == "BSE" && $college == "CBA"){
			$ret = "BSENTREP";
		}elseif ($ret == "BSA" && $college == "CADBE") {
			$ret = "BS-ARCHI";
		}elseif($ret == "BSBAMM"){
			$ret = "BSBA-MM";
		}elseif($ret == "BAPR" && $college == "COC"){
			$ret = "BADPR";
		}elseif($ret == "BAB" && $college == "COC"){
			$ret = "BA Broadcasting";
		}elseif($ret == "BEE" && $college == "COED"){
			$ret = "BEED";
		}elseif($ret == "BECE" && $college == "COED"){
			$ret = "BECED";
		}elseif($ret == "BSEE" && $college == "COED"){
			$ret = "BSEDEN";
		}elseif($ret == "BSEF" && $college == "COED"){
			$ret = "BSEDFL";
		}elseif($ret == "BSEM" && $college == "COED"){
			$ret = "BSEDMT";
		}elseif($ret == "BSES" && $college == "COED"){
			$ret = "BSEDSC";
		}elseif($ret == "BSESS" && $college == "COED"){
			$ret = "BSEDSS";
		}elseif($ret == "BSES" && $college == "CHK"){
			$ret = "BSESS";
		}elseif($ret == "BSP" && $college == "CSSD"){
			$ret = "BSPSY";
		}elseif($ret == "BSAM" && $college == "CS"){
			$ret = "BSAPMATH";
		}elseif($ret == "BSB" && $college == "CS"){
			$ret = "BSBIO";
		}elseif($ret == "BSC" && $college == "CS"){
			$ret = "BSCHEM";
		}elseif($ret == "BSM" && $college == "CS"){
			$ret = "BSMATH";
		}elseif($ret == "BSS" && $college == "CS"){
			$ret = "BSSTAT";
		}elseif($ret == "BPATA" && $college == "CAL"){
			$ret = "BPEA";
		}elseif($ret == "BSP" && $college == "CS"){
			$ret = "BSPHY";
		}elseif($ret == "BSC" && $college == "CS"){
			$ret = "BSCHEM";
		}
	    return $ret;
    }
}
