<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiDocsParam extends Model
{
    //
    protected $guarded = ['_token','_method'];
	
	protected $connection = 'sqlite';






}
