<?php

namespace App\Utility\Sites;

use App\Models\Sites;
use App\Models\Pages;
use App\Models\Robot;

class RobotHelper {

    protected $default;
    protected $file = 'robots.txt';

    public function __construct(Sites $site)
    {
    	$this->site = $site;
    	$this->default = new \stdClass();
    	$this->robot = $this->site->robot()->first();
    }

    public function getData()
    {
    	if(is_null($this->robot)) {
    		return false;
    	} else {
    		return $this->robot->data;
    	}
    }

    public function setData($data)
    {
    	if(is_object($data)) {

    		if(is_null($this->robot)) {
	    		$this->robot = Robot::create([
	    			"siteid" => $this->site->id,
	    			"data" => $data
	    		]);
    		} else {
    			$this->robot->data = $data;
    			$this->robot->save();
    		}

    		return $this->save_file();
    	} else {
    		$this->error = "invalid input provided";
    		return false;
    	}
    }

	public function add($pageid, $pagename)
	{
		if(is_numeric($pageid)) {

			if(is_null($this->robot)) {
				$data = $this->default;
				$data->$pageid = $pagename;
				$this->robot = \App\Models\Robot::create([
	    			"siteid" => $this->site->id,
	    			"data" => $data
	    		]);
			} else {
				$this->robot->data->$pageid = $pagename;
    			$this->robot->save();
			}

			return $this->robot;

		} else {
			$this->error = "invalid input provided";
			return false;
		}
	}

	public function remove($pageid)
	{
		if(is_numeric($pageid)) {
			if(!is_null($this->robot) && isSet($this->robot->data->$pageid)) {
				unSet($this->robot->data->$pageid);
				$this->robot->save();
			}
		} else {
			$this->error = "invalid input provided";
			return false;
		}
	}

	public function save_file()
	{
		$content = '';
		foreach($this->robot->data as $id => $name)
		{
			$content .= 'Disallow: /'.$name."\n";
		}
		return $this->site->storage()->writeFile($this->file, $content);
	}

	/** This function was only to convert robots.txt file to db object **/
	public function entries_from_file()
	{
		$contents = $this->site->storage()->readPage($this->file);

		if(!empty($contents)) {

			$data = $this->default;
			$lines = explode("\n", $contents);

			foreach($lines as $line) {

				$pagename = trim(str_replace('Disallow: /', '', $line));

				if(!empty($pagename)) {

					$pageid = Pages::getIdByName($this->site->id, $pagename);

					if($pageid) {
						$data->{$pageid} = $pagename;
					}
				}
			}
//dd($data);
			$this->robot = Robot::create([
    			"siteid" => $this->site->id,
    			"data" => $data
    		]);
			return $this->save_file();
		}


	}
}
