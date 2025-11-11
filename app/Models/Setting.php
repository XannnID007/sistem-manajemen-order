<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'pangkalan_name',
        'pangkalan_address',
        'pangkalan_phone',
        'logo',
        'price_per_unit',
    ];

    public static function get()
    {
        return self::first() ?? self::create([
            'pangkalan_name' => 'Pangkalan LPG',
            'pangkalan_address' => 'Bandung, Indonesia',
            'pangkalan_phone' => '081234567890',
            'price_per_unit' => 20000,
        ]);
    }
}
