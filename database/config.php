<?php
    
/**
 * Database Connections Configuration
 * -----------------------------------
 *	This is the configuration for the mysql connection
 *	The default setting should be the default configuration of MySQL in Laboratory classes
 */

if(parse_url($_SERVER['HTTP_HOST'], PHP_URL_PATH) == "localhost"){
	return [
	
		/**
		 * Database Server Host
		 */
		'server' => 'localhost',
	
		/**
		 * Database Username
		 */
		'username' => 'root',
	
		/**
		 * Database Password
		 */
		'password' => '',
	
		/**
		 * Use Database
		 */
		'database' => 'phinterest',
	
	];
}

return [

	/**
	 * Database Server Host
	 */
    'server' => 'localhost',

	/**
	 * Database Username
	 */
    'username' => 'u1343574_admin',

	/**
	 * Database Password
	 */
    'password' => 'Umjiumji123A',

	/**
	 * Use Database
	 */
    'database' => 'u1343574_phinterest',

];