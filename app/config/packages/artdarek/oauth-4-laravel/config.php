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
            'client_id'     => 'mu6ovnovbhu0o5i3anetwa8gc106u0w4',
            'client_secret' => 'iQD1fsDGJmQ8NGcoipaidLHXO88Fwd4H',
            'scope'         => array(),
        ),
	)

);
