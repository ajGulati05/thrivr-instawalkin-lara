<?php

declare(strict_types=1);

namespace App\Http\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * A model that has a slug property, which is used to generate unique
 * looking URLs
 * @author Roelof Roos <github@roelof.io>
 * @license MPL-2.0
 */
abstract class UuidModel extends Model
{
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(static function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     * @var string
     */
    protected $keyType = "uuid";
}
