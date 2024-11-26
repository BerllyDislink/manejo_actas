<?php

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
    protected $primaryKey = null; // No hay una clave primaria definida
    public $timestamps = false;

    protected $fillable = [
        'MIEMBROS_IDMIEMBROS',
        'TAREAS_IDTAREAS',
        'ESTADO',
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'MIEMBROS_IDMIEMBROS');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'TAREAS_IDTAREAS');
    }
	    // Especifica que no hay clave primaria
		public function getKeyName()
		{
			return null; // Sin clave primaria
		}
}
