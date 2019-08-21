<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Localheinz\Json\Printer\Printer;

class ApiDoc extends Model
{
    //

    protected $guarded = ['_token','_method'];
	
	protected $connection = 'sqlite';


    public function setRequestAttribute($value)
    {

        $this->attributes['request'] = (string)$value;
    }


    public function setResponseAttribute($value)
    {

        $this->attributes['response'] = (string)$value;
    }






    public function params()
    {
        return $this->hasMany(\App\ApiDocsParam::class,'api_docs_id');
    }





}
