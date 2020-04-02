<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

use Carbon\Carbon; 

class FeedController extends Controller
{
    //

    public function generateStateQuery($state){

    		//day and state comes from form submission
    	
    	return $query = "states/daily?state=".$state; 
    		// NY&date=".$state; 
    

    }


    public function parseDate($date_from_form){

  //  
	$datestring = strtotime($date_from_form); 
	// $timelogged_timestamp_string = Carbon::parse($date_from_form);
	// $time = strtotime($time); 

	// $date = $day + $time;
	//converting the datestring to the format of timelogged  
	return $datestring = date('Ymd', $datestring);

	// $timelogged_timestamp = Carbon::parse($date_from_form, 'UTC');

		 
    }


    // public function generateDate($date){

    	

    // 	if($yesterday = TRUE){

    // 		$day = $today->
    // 	}

    // 	if($today = FALSE){

    // 		$day = $today->subDays(2); 

    // 	}

    // 	// is the date today or yesterday

    // }

    public function compileQuery($statequery, $day){

    	return $query = $statequery."&date=".$day;

    }

    public function compilePageData(){

    	$date1_from_form = '2020-03-31 11:08 AM';
    	$date2_from_form = '2020-03-30 11:08 AM';

    	$state_from_form = 'PA'; 

    	$day1 = $this->parseDate($date1_from_form); 
    	$day2 = $this->parseDate($date2_from_form); 

    	$state = $state_from_form; 

    	$state_query = $this->generateStateQuery($state); 

    	//compile the query string
    	$query1 = $this->compileQuery($state_query, $day1); 

    	$query2 = $this->compileQuery($state_query, $day2); 

    	//run the queries to generate page
    	$page_data_day1 = $this->queryApi($query1); 
    	$page_data_day2 = $this->queryApi($query2); 
    	echo '<pre>';
    	var_dump($page_data_day1);
    	echo '</pre>';

    	echo '<pre>';
    	var_dump($page_data_day2);
    	echo '</pre>';

    }

    public function queryAPI($query){
		$client = new Client();


		$base_url = env('BASE_URL');
		$apikey = env('API_KEY'); 
		
		$curlstring = $base_url; 

		$curlstring.= $query; 


		$response = $client->get($curlstring);
    
		if($response->getStatusCode() == 200){

		$data = $response->getBody()->getContents();
		
		$result = json_decode($data, true);

		}
		else 
			$result = null; 

		return $result; 

       
		

	}

}