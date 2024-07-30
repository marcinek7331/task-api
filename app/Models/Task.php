<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const TABLE = 'tasks';

    public const SIZE = 'size';
    public const STATUS = 'status';
    public const RESULT = 'result';

    protected $fillable = [
        self::SIZE,
        self::STATUS,
        self::RESULT,
    ];

    protected $casts = [
        self::RESULT => 'array',
    ];
}
