<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seqno extends Model
{

    protected $fillable = ['lno','cno','type','year'];

    protected $table;

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'seqnos';
    }
}
