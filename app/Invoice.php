<?php

namespace App;

use App\Clinic;
use App\InvoiceLine;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
    	'clinic_id',
        'invoice_no',
        'invoice_date',
        'payment_date',
    	'retention',
    	'sub_total',
    	'total',
    ];

    protected $dates = [
        'invoice_date',
        'payment_date'
    ];

    public function clinic(){
    	return $this->belongsTo(Clinic::class)->first();
    }

    public function invoiceLines(){
      return $this->hasMany(InvoiceLine::class);
    }

    public function setSubTotalAttribute($sub_total)
    {
        $fig = (int) str_pad('1', 3, '0');
        $sub_total =  (floor($sub_total * $fig) / $fig);
        $this->attributes['sub_total'] = $sub_total;
    }

    public function setTotalAttribute($total)
    {
        $fig = (int) str_pad('1', 3, '0');
        $total =  (ceil($total * $fig) / $fig);
        $this->attributes['total'] = $total;
    }
}
