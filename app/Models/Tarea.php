<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tarea
 *
 * @property int $IDTAREAS
 * @property string $DESCRIPCION
 * @property Carbon $FECHA_ENTREGA
 * @property int $SESION_IDSESION
 *
 * @property Sesion $sesion
 * @property Collection|EncargadosTarea[] $encargados_tareas
 *
 * @package App\Models
 */
class Tarea extends Model
{
	protected $table = 'tareas';
	protected $primaryKey = 'IDTAREAS';
	public $timestamps = false;

	protected $casts = [
		'FECHA_ENTREGA' => 'datetime',
		'SESION_IDSESION' => 'int'
	];

	protected $fillable = [
		'DESCRIPCION',
		'FECHA_ENTREGA',
		'SESION_IDSESION',
	];

	public function sesion()
	{
		return $this->belongsTo(Sesion::class, 'SESION_IDSESION');
	}

	public function encargados_tareas()
	{
		return $this->hasMany(EncargadosTarea::class, 'TAREAS_IDTAREAS');
	}
}
