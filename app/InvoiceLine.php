<?php

namespace App;

use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $table = 'invoice_lines';

    protected $fillable = [
    	'invoice_id',
    	'description',
        'quantity',
    	'unit_price',
    	'total',
    ];

    public function invoice(){
    	return $this->belongsTo(Invoice::class);
    }
}
