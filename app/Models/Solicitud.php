<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Solicitud
 * 
 * @property int $ID_SOLICITUD
 * @property string $DEPENDENCIA
 * @property string $ASUNTO
 * @property string $DESICION
 * @property Carbon $FECHA_DE_SOLICITUD
 * @property int $SOLICITANTE_IDSOLICITANTE
 * @property int $SESION_IDSESION
 * @property int $DESCRIPCION_IDDESCRIPCION
 * 
 * @property Descripcion $descripcion
 * @property Sesion $sesion
 * @property Solicitante $solicitante
 *
 * @package App\Models
 */
class Solicitud extends Model
{
	protected $table = 'solicitud';
	protected $primaryKey = 'ID_SOLICITUD';
	public $timestamps = false;

	protected $casts = [
		'FECHA_DE_SOLICITUD' => 'datetime',
		'SOLICITANTE_IDSOLICITANTE' => 'int',
		'SESION_IDSESION' => 'int',
		'DESCRIPCION_IDDESCRIPCION' => 'int'
	];

	protected $fillable = [
		'DEPENDENCIA',
		'ASUNTO',
		'DESICION',
		'FECHA_DE_SOLICITUD',
		'SOLICITANTE_IDSOLICITANTE',
		'SESION_IDSESION',
		'DESCRIPCION_IDDESCRIPCION'
	];

	public function descripcion()
	{
		return $this->belongsTo(Descripcion::class, 'DESCRIPCION_IDDESCRIPCION');
	}

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}

	public function solicitante()
	{
		return $this->belongsTo(Solicitante::class, 'SOLICITANTE_IDSOLICITANTE');
	}
}
