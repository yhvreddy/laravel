<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DefaultModel;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
class DefaultController extends Controller
{

    public function users(){
        return User::all();
    }

    public function isLoggedin(){
        if(session()->exists('islogin') && session()->get('islogin') == 1){
        }else{
            redirect('/login');
        }
    }

    public function upload_file($request,$name,$path){
        if($request->hasfile($name)){
            $file = $request->file($name);
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move($path,$filename);
            return array('response' => 1, 'message' => 'Uploaded Success', 'upload' => $path.'/'.$filename);
        }else{
            return array('response' => 0, 'message' => 'No File To Upload', 'upload' => '');
        }
    }


    function genPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function success($redirectlink,$message){
        return Redirect::to($redirectlink)->withSuccess($message);
    }

    public function failed($redirectlink,$message){
        return Redirect::to($redirectlink)->withErrors($message);
    }

    public function print_r($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    //clean string without any special chars
    public function clean_string($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    //getting first litter of each word
    public function initial_litters($str) {
        $ret = '';
        foreach (explode(' ', $str) as $word)
            @$ret .= strtoupper($word[0]);
        return $ret;
    }

    //ramdom number gen--
    public function generateRandom($min, $max) {
        if (function_exists('random_int')):
            return random_int($min, $max); // more secure
        elseif (function_exists('mt_rand')):
            return mt_rand($min, $max); // faster
        endif;
        return rand($min, $max); // old
    }

    //ramdom char---
    public function random_string($length) {
        $key = '';
        $keys = array_merge(range('A', 'Z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    //generate letters A-Z
    public function generate_letters($totallength){
        $len = -1;
        $length = '';
        for ($char = 'A'; $char <= 'Z'; $char++) {
            $len++;
            if ($len == $totallength) {
                break;
            }
            $length .= $char.',';
        }
        return json_encode(trim($length,','));
    }

    //Two Dates and time differences
    public function days_ago($startingdate = NULL,$endingdate = NULL){
        $date1 = date_create($startingdate);
        $date2 = date_create($endingdate);
        //difference between two dates
        $diff = date_diff($date1,$date2);
        $text       = 'The difference is ';
        $year       =  $diff->y;
        $month      =  $diff->m;
        $days       =  $diff->d;
        $hours      =  $diff->h;
        $minutes    =  $diff->i;
        $secound    =  $diff->s;
        $daysdiff   =  $diff->format("%a");
        return $data = array('text'=>$text,'year'=>$year,'month'=>$month,'days'=>$days,'hours'=>$hours,'min'=>$minutes,'sec'=>$secound,'diff'=>$daysdiff);
        //count days
        //echo 'Days Count - '.$diff->format("%a");
    }
}
