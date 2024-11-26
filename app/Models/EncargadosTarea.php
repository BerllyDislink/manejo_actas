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
    // Establece la tabla asociada
    protected $table = 'encargados_tareas';

    // Define la clave primaria si no es 'id'

	public $incrementing = false;
    protected $primaryKey = null; // Si no hay clave primaria definida, usa null

    // Indica que no se usará la columna de timestamps
    public $timestamps = false;

    // Agrega las columnas que se pueden llenar
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
