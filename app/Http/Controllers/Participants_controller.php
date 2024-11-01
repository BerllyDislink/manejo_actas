<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Models\Invitado;
use App\Models\AsistenciaInvitado;
use App\Models\Miembro;
use App\Models\AsistenciaMiembro;

class Participants_controller extends Controller
{

    //MIEMBROS
    // Agregar un miembro como participante
    public function agregarMiembro(Request $request)
    {
        // Validar los datos del miembro
        $data = $request->validate([
            'NOMBRE' => 'required|string|max:50',
            'CARGO' => 'required|string|max:50',
        ]);
    
        // Crear un nuevo miembro
        $miembro = Miembro::create([
            'NOMBRE' => $data['NOMBRE'],
            'CARGO' => $data['CARGO'],
        ]);
    
        return response()->json(['mensaje' => 'Miembro agregado correctamente.', 'miembro' => $miembro]);
    }
    

    //verificar asistencia de miembro 

    public function obtenerAsistenciaMiembro($IDSESION, $IDMIEMBRO)
    {
        // Verifica que la sesión existe
        $sesion = Sesion::findOrFail($IDSESION);
    
        // Busca la asistencia del miembro en la sesión
        $asistencia = $sesion->asistencia_miembros()
                             ->where('MIEMBRO_IDMIEMBRO', $IDMIEMBRO)
                             ->first();
    
        // Verifica si se encontró la asistencia
        if ($asistencia) {
            return response()->json([
                'mensaje' => 'Asistencia encontrada.',
                'asistencia' => $asistencia
            ]);
        } else {
            return response()->json(['mensaje' => 'No se encontró asistencia para este miembro en la sesión.'], 404);
        }
    }
    

  //Registrar asistencia de miembro
  public function registrarAsistenciaMiembro(Request $request, $IDSESION, $IDMIEMBRO)
  {
      // Valida la solicitud
      $request->validate([
          'estado_asistencia' => 'required|in:Asistió,No Asistió' // Valores posibles
      ]);
  
      // Verifica que la sesión y el miembro existen
      $sesion = Sesion::findOrFail($IDSESION);
      $miembro = Miembro::findOrFail($IDMIEMBRO);
  
      // Registra o actualiza la asistencia del miembro
      $asistencia = AsistenciaMiembro::updateOrCreate(
          [
              'SESSION_IDSESION' => $IDSESION,
              'MIEMBRO_IDMIEMBRO' => $IDMIEMBRO,
          ],
          [
              'ESTADO_ASISTENCIA' => $request->estado_asistencia
          ]
      );
  
      return response()->json(['mensaje' => 'Asistencia registrada con éxito.', 'asistencia' => $asistencia]);
  }
  
  
  


    //INVITADOS
    public function agregarInvitado(Request $request)
    {
        // Validar los datos del invitado
        $data = $request->validate([
            'NOMBRE' => 'required|string|max:50',
            'DEPENDENCIA' => 'required|string|max:50',
            'CARGO' => 'required|string|max:50',
        ]);
    
        // Crear un nuevo invitado
        $invitado = Invitado::create([
            'NOMBRE' => $data['NOMBRE'],
            'DEPENDENCIA' => $data['DEPENDENCIA'],
            'CARGO' => $data['CARGO'],
        ]);
    
        return response()->json(['mensaje' => 'Invitado agregado correctamente.', 'invitado' => $invitado]);
    }
    
    //verificar asistencia de invitado

    public function obtenerAsistenciaInvitado($IDSESION, $IDINVITADOS)
{
    // Verifica que la sesión existe
    $sesion = Sesion::findOrFail($IDSESION);

    // Busca la asistencia del invitado en la sesión
    $asistencia = $sesion->asistencia_invitados()
        ->where('INIVITADO_IDINVITADO', $IDINVITADOS)
        ->first();

    // Verifica si se encontró la asistencia
    if ($asistencia) {
        return response()->json([
            'mensaje' => 'Asistencia encontrada.',
            'asistencia' => $asistencia
        ]);
    } else {
        return response()->json(['mensaje' => 'No se encontró asistencia para este invitado en la sesión.'], 404);
    }
}

//Registar asistencia 

public function registrarAsistencia(Request $request, $IDSESION, $IDINVITADOS)
{
    // Valida la solicitud
    $request->validate([
        'estado_asistencia' => 'required|in:Asistió,No Asistió' // Validación específica
    ]);

    // Verifica que la sesión existe
    $sesion = Sesion::findOrFail($IDSESION);

    // Verifica que el invitado existe
    $invitado = Invitado::findOrFail($IDINVITADOS);

    // Registra o actualiza la asistencia del invitado
    $asistencia = AsistenciaInvitado::updateOrCreate(
        [
            'INIVITADO_IDINVITADO' => $IDINVITADOS,
            'SESION_IDSESION' => $IDSESION // Asegúrate de incluir esto
        ],
        [
            'ESTADO_ASISTENCIA' => $request->estado_asistencia
        ]
    );

    return response()->json(['mensaje' => 'Asistencia registrada con éxito.', 'asistencia' => $asistencia]);
}




    
    
}
