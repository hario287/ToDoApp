<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    
    protected $fillable = [
        'task_id','checked_red','checked_blue','checked_yellow','checked_green',
    ];

    protected $casts = [
        'checked_red' => 'boolean',
        'checked_blue' => 'boolean',
        'checked_yellow' => 'boolean',
        'checked_green' => 'boolean'
    ];
    public function task() {
        return $this->belongsTo('App/Models/Task');
    }
}
