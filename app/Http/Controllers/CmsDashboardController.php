<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Analytics;
use DateTime;

class CmsDashboardController extends Controller{
    public function index(){
    	return view('cms.dashboard.index');
    }

    public function getData(request $req){
    	if ($req->input('sDate') != null) {
	    	$dateS  = new DateTime($req->input('sDate')." 00:00:01");
		    $dateE  = new DateTime($req->input('eDate')." 23:59:50");
    	}else{
	    	$dateS  = new DateTime("2019/04/01 00:00:01");
		    $dateE  = new DateTime("2019/04/10 23:59:50");
    	}
	    $period = Period::create($dateS, $dateE);

    	$api = array();
    	$api['type'] = 'dashboard_data';
    	$api['msg'] = 'Success get data dashboard';
		// $api['bounceRate'] = Analytics::performQuery($period, "ga:bounceRate")->rows;
        // $api['avgSessionDuration'] = Analytics::performQuery($period, "ga:avgSessionDuration")->rows;
		$api['browser'] = $this->dataBrowser($period);
		// $api['country'] = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:country"))->rows;
		// $api['city'] = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:city"))->rows;
  //       $api['VisitorWebsite'] = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:date"))->rows;
		// $api['MostVisitedPages'] = Analytics::fetchMostVisitedPages($period);
		// $api['VisitorsAndPageViews'] = Analytics::fetchVisitorsAndPageViews($period);
        // $api['userVisited'] = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:userGender,ga:userAgeBracket"))->rows;

		return response()->json($api);
    }

    private function dataBrowser($period){
    	return $rawdata = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:browser"))->rows;
    	$data = array();
    	$data['type'] = 'horizontalBar';
    	$labels = array();
    	$values = array();
    	foreach ($rawdata as $list) {
    		array_push($labels, $list[0]);
    		array_push($values, $list[1]);
    	}
    	$data['data']['labels'] = $labels;
    	$datasets =  array();
    	$datasets['label'] = 'Top Browsers';
    	$datasets['data'] = $values;
    	$datasets['backgroundColor'] = $this->getRandColor();
    	$data['data']['datasets'] = $datasets;

    	return $data;
    }

    private function getRandColor(){
    	return 'rgb('.rand(0,255).','.rand(0,255).','.rand(0,255).')';
    }
}
