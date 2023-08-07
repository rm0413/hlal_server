<?php


namespace App\Helpers;
use Request;
use App\Models\ActivityLogs as LogActivityModel;


class LogActivity
{

    public static function addToLog($subject, $users, $status)
    {
    	$log = [];
    	$log['subject'] = $subject;
		$log['status']	= $status;
    	$log['url']     = Request::fullUrl();
    	$log['method']  = Request::method();
    	$log['ip']      = Request::ip();
    	$log['agent']   = Request::header('user-agent');
    	$log['emp_id'] = $users;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
