<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AsistenciaInvitado
 * 
 * @property int $INIVITADO_IDINVITADO
 * @property int $SESION_IDSESION
 * @property string $ESTADO_ASISTENCIA
 * 
 * @property Invitado $invitado
 * @property Sesion $sesion
 *
 * @package App\Models
 */
class AsistenciaInvitado extends Model
{
	protected $table = 'asistencia_invitado';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'INIVITADO_IDINVITADO' => 'int',
		'SESION_IDSESION' => 'int'
	];

	protected $fillable = [
		'INIVITADO_IDINVITADO',
		'SESION_IDSESION',
		'ESTADO_ASISTENCIA',
	];
	

	public function invitado()
	{
		return $this->belongsTo(Invitado::class, 'INIVITADO_IDINVITADO');
	}

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}
}
