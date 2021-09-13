<?php namespace Model;

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
 * @subpackage  Gas ORM Model
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
 * Model\Kid Class.
 *
 * This dummy kid model, serve all test corresponding with Kid table and its relation
 *
 * @package     Gas ORM
 * @since     	2.0.0
 */

use \Gas\Core;
use \Gas\ORM;

class Kid extends ORM {

	/**
	 * Set up method for unit testing
	 */
	public static function setUp()
	{
		// Generate a reflection and sync DB
		$reflection  = self::make();
		self::syncdb($reflection);

		// Then add some dummy data
		$data = array(
		    array('id' => 1, 'user_id' => 1, 'name' => 'Daria Doe', 'age' => 1),
		    array('id' => 2, 'user_id' => 1, 'name' => 'John Doe Jr', 'age' => 2),
		    array('id' => 3, 'user_id' => 2, 'name' => 'Abraham Jones', 'age' => 3),
		    array('id' => 4, 'user_id' => 2, 'name' => 'Chyntia Jones', 'age' => 4),
		    array('id' => 5, 'user_id' => 2, 'name' => 'Laura Jones', 'age' => 5),
		    array('id' => 6, 'user_id' => 3, 'name' => 'Dolly Sinatra', 'age' => 6),
		);

		if ( ! self::driver('sqlite'))
		{
			self::insert_batch($data); 
		}
		else
		{
			foreach ($data as $entry)
			{
				$mirror = $reflection;
				$mirror->record->set('data', $entry);
				$mirror->save();
			}
		}
	}

	function _init()
	{
		// Define relationships
		self::$relationships = array(
			'user'  => ORM::belongs_to('\\Model\\User', array('select:id,name,username')),
		);

		// Define fields definition
		self::$fields = array(
			'id'       => ORM::field('auto[3]'),
			'user_id'  => ORM::field('int[3]'),
			'name'     => ORM::field('char[40]'),
			'age'      => ORM::field('int[3]'),
		);
	}
}