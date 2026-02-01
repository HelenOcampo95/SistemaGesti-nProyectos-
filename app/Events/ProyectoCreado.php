<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProyectoCreado implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;


    // Recibimos el ID del docente y el nuevo número de proyectos
    public function __construct()
    {
        
    }

    // El canal por donde se enviará el mensaje (debe ser el mismo que pusiste en JS)
    public function broadcastOn()
    {
        return [
            new Channel('dashboard.institucional'),
    
        ];
    }

    public function broadcastAs()
    {
        return 'ProyectoCreado';
    }


}