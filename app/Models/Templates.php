<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Templates
 *
 * @property int $id
 * @property string $title
 * @property string $html
 * @property string $thumbnail
 * @property string $type
 *
 * @package App\Models
 */
class Templates extends Model
{
    protected $table = 'templates';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'html',
        'thumbnail',
        'type'
    ];
}