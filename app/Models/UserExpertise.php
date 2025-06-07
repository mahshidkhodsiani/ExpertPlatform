<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'category',
    ];

    /**
     * رابطه با مدل User
     * هر تخصص متعلق به یک کاربر است
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
