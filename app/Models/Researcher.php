<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Researcher
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Researcher extends Model
{

    static $rules = [
		'nombre' => 'required',
		'orcid' => '',
		'name' => '',
		'familyName' => '',
		'keywords' => '',
		'email' => '',
    ];

    protected $perPage = 20;
    protected $casts = [
        'keywords' => 'array'
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orcid',
        'nombre',
        'name',
        'familyName',
        'keywords',
        'email'];



}
