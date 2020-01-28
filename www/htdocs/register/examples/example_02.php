<?php
/*!
* Details how to use users in a similar fashion to Hybridauth 2. Note that while Hybridauth 3 provides 
* a similar interface to Hybridauth 2, both versions are not fully compatible with each other.
*/

include $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/hybridauth/src/autoload.php";

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

/*    
	'callback' => 'https://dev-repmyblock.repmyblock.nyc/register/examples/example_01.php', // or Hybridauth\HttpClient\Util::getCurrentUrl()
  'keys' => [ 'id' => '', 'secret' => '' ], // Your Github application credentials
*/

$config = [
    'callback' => HttpClient\Util::getCurrentUrl(),

    'providers' => [
        'GitHub' => [ 
            'enabled' => true,
            'keys'    => [ 'id' => '9c25c478e81b739da219', 'secret' => 'f236b34dfd25f89044360ce58a46c0b1a80ecb5b' ], 
        ],

        'Google' => [ 
            'enabled' => true,
            'keys'    => [ 'id' => '', 'secret' => '' ],
        ],

        'Facebook' => [ 
            'enabled' => true,
            'keys'    => [ 'id' => '', 'secret' => '' ],
        ],

        'Twitter' => [ 
            'enabled' => true,
            'keys'    => [ 'key' => '', 'secret' => '' ],
        ]
    ],


    /* optional : set debug mode
        'debug_mode' => true,
        // Path to file writeable by the web server. Required if 'debug_mode' is not false
        'debug_file' => __FILE__ . '.log', */

    /* optional : customize Curl settings
        // for more information on curl, refer to: http://www.php.net/manual/fr/function.curl-setopt.php  
        'curl_options' => [
            // setting custom certificates
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO         => '/path/to/your/certificate.crt',

            // set a valid proxy ip address
            CURLOPT_PROXY => '*.*.*.*:*',

            // set a custom user agent
            CURLOPT_USERAGENT      => ''
        ] */
];

try {    
    $hybridauth = new Hybridauth( $config );

    $adapter = $hybridauth->authenticate( 'GitHub' );

    ///$adapter = $hybridauth->authenticate( 'Google' );
    // $adapter = $hybridauth->authenticate( 'Facebook' );
    // $adapter = $hybridauth->authenticate( 'Twitter' );

    $tokens = $adapter->getAccessToken();
    $userProfile = $adapter->getUserProfile();

    // print_r( $tokens );
    // print_r( $userProfile );

    $adapter->disconnect();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
