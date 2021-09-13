<?php namespace Gas;

/**
 * CodeIgniter Gas ORM Packages
 *
 * A lighweight and easy-to-use ORM for CodeIgniter
 * 
 * This packages intend to use as semi-native ORM for CI, 
 * based on the ActiveRecord pattern. This ORM uses CI stan-
 * dard DB utility packages also validation class.
 *
 * @package     Gas ORM
 * @category    ORM
 * @version     2.1.2
 * @author      Taufan Aditya A.K.A Toopay
 * @link        http://gasorm-doc.taufanaditya.com/
 * @license     BSD
 *
 * =================================================================================================
 * =================================================================================================
 * Copyright 2011 Taufan Aditya a.k.a toopay. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 * 
 * 1. Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * 
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY Taufan Aditya a.k.a toopay ‘’AS IS’’ AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
 * FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Taufan Aditya a.k.a toopay OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * The views and conclusions contained in the software and documentation are those of the
 * authors and should not be interpreted as representing official policies, either expressed
 * or implied, of Taufan Aditya a.k.a toopay.
 * =================================================================================================
 * =================================================================================================
 */

/**
 * Gas\Janitor Class.
 *
 * @package     Gas ORM
 * @since     	2.0.0
 */

class Janitor {

	/**
	 * Returning a real path of any environment paths
	 *
	 * @param string 'app' will resulted APPPATH adn 'base' will resulted in BASEPATH
	 * @return string Real path
	 */
	public static function path($type = '')
	{
		$type = strtolower($type);

		// Validate
		if ( ! in_array($type, array('app','base')))
		{
			throw new \InvalidArgumentException('empty_arguments:path');
		}

		// Get original constants
		switch ($type) 
		{
			case 'app':
				$path = realpath(APPPATH);
				break;
			
			case 'base':
				$path = realpath(BASEPATH);
				break;
		}

		return (substr($path, -1) !== DIRECTORY_SEPARATOR) ? $path . DIRECTORY_SEPARATOR : $path;
	}

	/**
	 * Validate passed input
	 *
	 * @param   mixed
	 * @param   bool
	 * @param   bool
	 * @return  mixed
	 */
	public static function get_input($method, $input, $die = FALSE, $default = FALSE)
	{
		if (empty($input))
		{
			if ($die) throw new \InvalidArgumentException('empty_arguments:'.$method);

			$input = $default;
		}

		return $input;
	}

	/**
	 * Trimed an array, recursively
	 *
	 * @access  public
	 * @param   array
	 * @return  array
	 */
	public static function arr_trim($arrays)
	{
		if ( ! is_array($arrays)) return trim($arrays);

		return array_map('\\Gas\\Janitor::arr_trim', $arrays);
	}
}