<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class DefaultModel extends Model
{

	/*
	*	Login User Details
	* */
	public function logindetails($tablename,$request)
	{
		return DB::table($tablename)->where('id',$request)->get();
	}

    /*
	*	Fetch All Data
	*/
	public function select_all_data($tablename)
	{
		$data = DB::table($tablename)->get();
		return $data;
	}

	/*
	*	Fetch Selected Data
	*/
	public function select_data($tablename,$selectdata,$conduction)
	{
		$data = DB::table($tablename)->select($selectdata)->where($conduction)->orderBy('id','DESC')->get();
		return $data;
	}


	/*
	*	Insertdata and get last inserted id
	*/
	public function insert_data($tablename,$insertdata)
	{
		$data = DB::table($tablename)->insertGetId($insertdata);
		return $data;
	}

	/*
	*	Update data
	*/
	public function update_data($tablename,$conduction,$insertdata){
		$data = DB::table($tablename)->where($conduction)->update($insertdata);
		return $data;
	}

	/*
	*	Delete data
	*/
	public function delete_data($tablename,$conduction){
		$data = DB::table($tablename)->where($conduction)->delete();
		return $data;
	}


	/*
	*	Multi Uploaded
	* */
	public function multiUploadfiles($request,$inputname,$folderpath)
	{
		$filepath = 'public/uploads/'.$folderpath.'/';
		if($request->hasfile($inputname)){
            $ramdom = rand('1','1000');
            foreach($request->file($inputname) as $file){
				//$name = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$filename = time().'.'.$extension;
                $file->move($filepath,$filename);
                $uploaddata[] = $filepath.$filename;
            }
        }else{
            $uploaddata = array();
		}
		return $uploaddata;
	}

	/*
	*	Upload SingleFile
	* */
	public function uploadfile($request,$inputname,$folderpath,$existingfile=null)
	{
		$filepath = 'public/uploads/'.$folderpath.'/';
		if($request->hasfile($inputname) && $_FILES[$inputname]['name'] != ''){
            $file = $request->file($inputname);
            $extension = $file->getClientOriginalExtension();
            $filename = time().'RD'.rand(1,999).'.'.$extension;
            $file->move($filepath,$filename);
            $uploaddata = $filepath.$filename;
        }else{
			if(!empty($existingfile)){
				$uploaddata = $existingfile;
			}else{
				$uploaddata = '';
			}
		}
		return $uploaddata;
	}
}
