<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenSesion
 * 
 * @property int $ID_ORDEN_SESION
 * @property string $TEMA
 * @property string $DESCRIPCION
 * @property int $SESION_IDSESION
 * 
 * @property Sesion $sesion
 *
 * @package App\Models
 */
class OrdenSesion extends Model
{
	protected $table = 'orden_sesion';
	protected $primaryKey = 'ID_ORDEN_SESION';
	public $timestamps = false;

	protected $casts = [
		'SESION_IDSESION' => 'int'
	];

	protected $fillable = [
		'TEMA',
		'DESCRIPCION',
		'SESION_IDSESION'
	];

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}
}
