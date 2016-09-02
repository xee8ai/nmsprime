<?php

namespace Modules\Ccc\Entities;

class Ccc extends \BaseModel {

	// The associated SQL table for this Model
	public $table = 'ccc';

	public $guarded = ['template_filename_upload'];

	// Add your validation rules here
	public static function rules($id = null)
	{
		return array(
		);
	}


	/**
	 * View related stuff
	 */

	// Name of View
	public static function view_headline()
	{
		return 'Ccc Config';
	}

	// link title in index view
	public function view_index_label()
	{
		return $this->view_headline();
	}


	/**
	 * Return file list for global config view - select field
	 * @return array 	filenames
	 */
	public static function template_files()
	{
		$files_raw = \Storage::files('config/ccc/template/');
		$files[null] = null;

		foreach ($files_raw as $file)
		{
			$name = explode('/', $file);
			$name = array_pop($name);
			$files[$name] = $name;
		}

		return $files;
	}

}