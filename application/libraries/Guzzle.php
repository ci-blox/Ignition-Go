<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guzzle
{
/* Guzzle: 
1) Consume Third Party API/Authentication: 
Whether you are implementing a facebook based authentication or showing some data which are fed from third-party web services, this is the tool you will want as your primary client to do such kind of jobs.
2) Scraping WebSite Data: 
If you are about to work on any web scraping related tasks, either create a crawler or collect and parse various kind of data content, this library is going to do wonder for you.

NOTE: requires PHP 5.5+

Example use:
$this->load->library('guzzle');
 
$client = new Client();
$response = $client->get("https://api.github.com/");
var_dump($response->json());

*/	
	public function __construct()
	{
       $php_required = '5.5';  
       if (is_php($php_required))
        {
            		require_once APPPATH . 'third_party/guzzle/autoloader.php';
        }
    }
}