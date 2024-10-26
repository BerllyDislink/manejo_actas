<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EncargadosTarea
 * 
 * @property string $ESTADO
 * @property int $MIEMBROS_IDMIEMBROS
 * @property int $TAREAS_IDTAREAS
 * 
 * @property Miembro $miembro
 * @property Tarea $tarea
 *
 * @package App\Models
 */
class EncargadosTarea extends Model
{
	protected $table = 'encargados_tareas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'MIEMBROS_IDMIEMBROS' => 'int',
		'TAREAS_IDTAREAS' => 'int'
	];

	protected $fillable = [
		'ESTADO'
	];

	public function miembro()
	{
		return $this->belongsTo(Miembro::class, 'MIEMBROS_IDMIEMBROS');
	}

	public function tarea()
	{
		return $this->belongsTo(Tarea::class, 'TAREAS_IDTAREAS');
	}
}
