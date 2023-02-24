<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id','name','status',
    ];
    
    public function user()
        {
            return $this->belongsTo(User::class);
        }
    public function tag() 
        {
            return $this->hasOne('App/Models/Tag');
        }

    // const STATUS = [
    // 1 => [ 'label' => '未着手' ],
    // 2 => [ 'label' => '完了' ],
    // ];

    // public function getStatusLabelAttribute()
    // {
    //     // 状態値
    //     $status = $this->attributes['status'];

    //     // 定義されていなければ空文字を返す
    //     if (!isset(self::STATUS[$status])) {
    //         return '';
    //     }

    //     return self::STATUS[$status]['label'];
    // }

    protected static function boot()
    {
        parent::boot();

        // 保存時user_idをログインユーザーに設定
        self::saving(function($task) {
            $task->user_id = \Auth::id();
        });
    }

}