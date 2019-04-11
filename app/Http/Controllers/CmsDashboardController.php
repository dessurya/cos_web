<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Analytics;
use DateTime;
use URL;
use Carbon\Carbon;

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
		$api['bounceRate'] = Analytics::performQuery($period, "ga:bounceRate")->rows;
        $api['avgSessionDuration'] = Analytics::performQuery($period, "ga:avgSessionDuration")->rows;
		$api['browser'] = $this->dataBrowser($period);
		$api['country'] = $this->dataCountry($period);
		$api['city'] = $this->dataCity($period);
        $api['dailyVisitor'] = $this->dataDailyVisitor($period);
		$api['visitedPages'] = $this->dataVisitedPages($period);
		
		// $api['dailyVisitAndView'] = $this->dataDailyVisitAndView($period);
  //       $api['userVisited'] = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:userGender,ga:userAgeBracket"))->rows;

		return response()->json($api);
    }

    private function dataBrowser($period){
    	$rawdata = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:browser"))->rows;
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		$send['label'] = $list[0];
	    		$send['value'] = $list[1];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function dataCountry($period){
    	$rawdata = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:country"))->rows;
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		$send['label'] = $list[0];
	    		$send['value'] = $list[1];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function dataCity($period){
    	$rawdata = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:city"))->rows;
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		$send['label'] = $list[0];
	    		$send['value'] = $list[1];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function dataDailyVisitor($period){
    	$rawdata = Analytics::performQuery($period, "ga:users", array("dimensions" => "ga:date"))->rows;
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		$send['label'] = Carbon::createFromFormat('Ymd',$list[0])->format('Y/m/d');
	    		$send['value'] = $list[1];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function dataVisitedPages($period){
    	$rawdata =Analytics::fetchMostVisitedPages($period);
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		$send['url'] = URL::to($list['url']);
	    		$send['label'] = $list['pageTitle'];
	    		$send['value'] = $list['pageViews'];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function dataDailyVisitAndView($period){
    	$rawdata = Analytics::fetchVisitorsAndPageViews($period);
    	$data = null;
    	if ($rawdata) {
	    	$data = array();
	    	foreach($rawdata as $list) {
	    		$send = array();
	    		// $send['date'] = Carbon::createFromFormat('Ymd',$list['date'])->format('Y/m/d');
	    		$send['date'] = $list['date'];
	    		$send['page'] = $list['pageTitle'];
	    		$send['visitors'] = $list['visitors'];
	    		$send['pageViews'] = $list['pageViews'];
	    		array_push($data, $send);
	    	}
    	}
    	return $data;
    }

    private function getRandColor(){
    	return 'rgb('.rand(0,255).','.rand(0,255).','.rand(0,255).')';
    }
}
