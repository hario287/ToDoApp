<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    public function user()
        {
            return $this->belongsTo(User::class);
        }

    // const STATUS = [
    // 0 => [ 'label' => '未着手', 'class' => 'label-danger' ],
    // 1 => [ 'label' => '完了', 'class' => '' ],
    // ];

    protected static function boot()
    {
        parent::boot();

        // 保存時user_idをログインユーザーに設定
        self::saving(function($task) {
            $task->user_id = \Auth::id();
        });
    }

}