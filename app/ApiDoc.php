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
        if(!empty($value))
        {
            $print = new Printer();
            $value = $print->print($value,'  ');
        }
        $this->attributes['request'] = app('other_service')->myfiter($value);
    }


    public function setResponseAttribute($value)
    {
        if(!empty($value))
        {
            $print = new Printer();
            $value = $print->print($value,'  ');
        }
        $this->attributes['response'] = app('other_service')->myfiter($value);
    }





    public function params()
    {
        return $this->hasMany(\App\ApiDocsParam::class,'api_docs_id');
    }





}
