<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class QrCode extends Model
{
    protected $fillable = [
        'qr_code_no',
        'qr_code_image',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
