<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Acta
 *
 * @property int $ID_ACTA
 * @property string $ESTADO
 * @property int $SESION_IDSESION
 *
 * @property Sesion $sesion
 *
 * @package App\Models
 */
class Acta extends Model
{
	protected $table = 'actas';
	protected $primaryKey = 'ID_ACTA';
	public $timestamps = false;

	protected $casts = [
		'SESION_IDSESION' => 'int'
	];

	protected $fillable = [
		'ESTADO',
		'SESION_IDSESION'
	];


    public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}
}
