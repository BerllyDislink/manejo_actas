<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invitado
 *
 * @property int $IDINVITADOS
 * @property string $NOMBRE
 * @property string $DEPENDENCIA
 * @property string $CARGO
 *
 * @property Collection|AsistenciaInvitado[] $asistencia_invitados
 *
 * @package App\Models
 */
class Invitado extends Model
{
    /**
     * @var int|mixed
     */

    protected $table = 'invitados';
	protected $primaryKey = 'IDINVITADOS';
	public $timestamps = false;

	protected $fillable = [
		'NOMBRE',
		'DEPENDENCIA',
		'CARGO',
        'user_id'
	];

	public function asistencia_invitados()
	{
		return $this->hasMany(AsistenciaInvitado::class, 'INIVITADO_IDINVITADO');
	}

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
