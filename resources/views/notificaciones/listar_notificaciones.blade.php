
    @forelse($notificaciones as $notif)
    <div class="d-flex flex-stack p-3 m-2 border-bottom border-gray-200 {{ $notif->leida == 0 ? 'bg-light-success' : 'bg-white' }}" style="border-radius: 20px;">
        <div class="d-flex align-items-center me-2">
            <div class="mb-0">
                <div class="fs-6 text-gray-800 fw-bold"> 
                    {{ $notif->titulo_notificacion }}
                </div>
                <div class="text-gray-400 fs-7">{{ $notif->descripcion_notificacion }}</div>
                <div class="text-gray-400 fs-7">
                        <a href="{{ $notif->url_notificacion }}" 
                        class="fs-8 text-success text-hover-success" 
                        onclick="marcarLeida(event, {{ $notif->id_notificacion }}, '{{ $notif->url_notificacion }}')">
                        Ver Más
                    </a>
                </div>
                <span class="text-gray-500 fs-9">{{ $notif->actualizado_en->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    @empty
        <div id="notificacion-vacia" class="text-center py-10">
            <div class="text-gray-400 fs-7">No tienes notificaciones por ahora.</div>
        </div>
    @endforelse
