<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class FrontendController extends Controller{
    public function api(){
    	$api = array();
    	//fetch the most visited pages for today and the past week
		$api['fetchMostVisitedPages'] = Analytics::fetchMostVisitedPages(Period::days(7));

		//fetch visitors and page views for the past week
		$api['fetchVisitorsAndPageViews'] = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    	dd($api);
    }
}
