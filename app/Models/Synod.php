<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Synod extends Model
{
    protected $fillable =[
        'corporate_name',
        'fantasy_name',
        'cnpj',
        'cep',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'website',
        'logo',
    ];
}
