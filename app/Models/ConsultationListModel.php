<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationListModel extends Model
{
    use HasFactory;
    protected $table = 'ConsultationList';

    protected $fillable = [
        'ConsultationList',
    ];
}
