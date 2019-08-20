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
        if(!empty($value) && !empty(json_decode($value)))
        {
            $print = new Printer();
            $value = $print->print($value,'  ');
        }
        $this->attributes['request'] = (string)$value;
    }


    public function setResponseAttribute($value)
    {
        if(!empty($value) && !empty(json_decode($value)))
        {
            $print = new Printer();
            $value = $print->print($value,'  ');
        }
        $this->attributes['response'] = (string)$value;
    }

    public function getRequestAttribute($value)
    {
        return str_replace(['\n','\r','\\'],'',$this->attributes['request']);
    }

    public function getResponseAttribute($value)
    {
        return str_replace(['\n','\r','\\',],'',$this->attributes['response']);
    }





    public function params()
    {
        return $this->hasMany(\App\ApiDocsParam::class,'api_docs_id');
    }





}
