<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),		
        
        /**
         * Box
         */
        'Box' => array(
            'client_id'     => $_ENV['oauth.Box.client_id'],
            'client_secret' => $_ENV['oauth.Box.client_secret'],
            'scope'         => array(),
        ),
	)

);
