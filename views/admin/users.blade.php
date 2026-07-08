@extends('layouts.app')
@section('title', 'ChanchullApp — Gestión de Usuarios')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:32px">
        <div class="label" style="color:#00f5d4;margin-bottom:4px">Admin</div>
        <h1 class="heading-lg">Gestión de Usuarios</h1>
        <p style="font-size:13px;color:rgba(255,255,255,0.3);margin-top:4px">{{ count($users) }} usuarios registrados</p>
    </div>

    @if($success)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.18);margin-bottom:20px;font-size:13px;color:#00ff88">
            <i class="fa-solid fa-circle-check" style="margin-right:6px"></i> {{ $success }}
        </div>
    @endif

    <div class="card" style="overflow:hidden">
        <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04)">
            <span style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.6)">
                <i class="fa-solid fa-users" style="color:#00f5d4;margin-right:8px"></i> Usuarios del sistema
            </span>
        </div>
        <div style="overflow-x:auto">
            <table class="gtable">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th style="text-align:right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                                        @if($u->photo)
                                            <img src="{{ $u->photo }}" alt="" style="width:100%;height:100%;object-fit:cover">
                                        @else
                                            <i class="fa-solid fa-user" style="font-size:13px;color:rgba(255,255,255,0.3)"></i>
                                        @endif
                                    </div>
                                    <span style="font-weight:500">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td style="color:rgba(255,255,255,0.45)">{{ $u->email }}</td>
                            <td>
                                <span class="badge {{ $u->role === 'admin' ? 'badge--cyan' : 'badge--green' }}">
                                    {{ $u->role === 'admin' ? 'Admin' : 'Usuario' }}
                                </span>
                            </td>
                            <td style="color:rgba(255,255,255,0.35);font-size:13px">{{ date('d/m/Y', strtotime($u->created_at)) }}</td>
                            <td style="text-align:right">
                                <button type="button" class="btn btn--ghost reset-btn"
                                    style="font-size:11px;padding:6px 12px"
                                    data-name="{{ addslashes($u->name) }}"
                                    data-url="/admin/reset/{{ $u->id }}">
                                    <i class="fa-solid fa-key" style="font-size:10px"></i> Resetear clave
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:48px;color:rgba(255,255,255,0.25)">No hay usuarios</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal de confirmación --}}
<div id="reset-modal" style="display:none;position:fixed;inset:0;z-index:100;align-items:center;justify-content:center;background:rgba(6,6,15,0.85);backdrop-filter:blur(8px)">
    <div class="card glow-border" style="padding:32px;max-width:400px;width:90%;text-align:center;animation:modalIn 0.3s ease">
        <div style="width:56px;height:56px;border-radius:50%;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.18);display:inline-flex;align-items:center;justify-content:center;font-size:22px;color:#ff6b6b;margin-bottom:16px">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:17px;margin-bottom:8px;color:#fff">¿Resetear contraseña?</h3>
        <p style="font-size:13px;color:rgba(255,255,255,0.4);line-height:1.6;margin-bottom:24px">
            ¿Estás seguro que deseas resetear la contraseña de <strong style="color:#fff" id="modal-user-name"></strong>? Se generará una nueva contraseña temporal.
        </p>
        <div style="display:flex;gap:10px;justify-content:center">
            <button id="modal-cancel" class="btn btn--ghost" style="padding:10px 20px">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </button>
            <form id="modal-confirm" method="POST" action="#" style="display:inline">
                <button type="submit" class="btn" style="padding:10px 20px;background:rgba(255,107,107,0.12);border:1px solid rgba(255,107,107,0.2);color:#ff6b6b;cursor:pointer">
                    <i class="fa-solid fa-key"></i> Sí, resetear
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
</style>

<script>
(function () {
    var modal = document.getElementById('reset-modal');
    var userName = document.getElementById('modal-user-name');
    var confirmBtn = document.getElementById('modal-confirm');
    var cancelBtn = document.getElementById('modal-cancel');

    document.querySelectorAll('.reset-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            userName.textContent = btn.getAttribute('data-name');
            confirmBtn.action = btn.getAttribute('data-url');
            modal.style.display = 'flex';
        });
    });

    cancelBtn.addEventListener('click', function () { modal.style.display = 'none'; });
    modal.addEventListener('click', function (e) { if (e.target === modal) modal.style.display = 'none'; });
})();
</script>
@endsection
