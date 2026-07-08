@extends('layouts.app')
@section('title', 'ChanchullApp — Mi Perfil')

@section('content')
<div style="max-width:600px;margin:0 auto;padding:32px 24px 80px">

    <div style="margin-bottom:32px">
        <div class="label" style="color:#7b61ff;margin-bottom:4px">Tu cuenta</div>
        <h1 class="heading-lg">Mi Perfil</h1>
    </div>

    @if($success)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.18);margin-bottom:20px;font-size:13px;color:#00ff88">
            <i class="fa-solid fa-circle-check" style="margin-right:6px"></i> {{ $success }}
        </div>
    @endif

    @if($error)
        <div style="padding:12px 16px;border-radius:10px;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.18);margin-bottom:20px;font-size:13px;color:#ff6b6b">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i> {{ $error }}
        </div>
    @endif

    {{-- Foto de perfil --}}
    <div class="card glow-border" style="padding:32px;text-align:center;margin-bottom:24px">
        <form method="POST" action="/perfil/photo" enctype="multipart/form-data" id="photo-form">
            <label for="photo-input" style="cursor:pointer;display:inline-block">
                <div class="avatar-ring" style="margin:0 auto 16px;width:100px;height:100px">
                    <div class="avatar-inner" style="font-size:36px">
                        @if($user->photo)
                            <img src="{{ $user->photo }}" alt="Avatar" style="width:100%;height:100%;border-radius:50%;object-fit:cover">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                </div>
                <div style="font-size:12px;color:rgba(255,255,255,0.3)">
                    <i class="fa-solid fa-camera" style="margin-right:4px"></i> Cambiar foto
                </div>
            </label>
            <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none" onchange="document.getElementById('photo-form').submit()">
        </form>
        <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:18px;margin-top:8px">{{ $user->name }}</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.35)">{{ $user->email }}</div>
        <div style="margin-top:8px">
            <span class="badge {{ $user->role === 'admin' ? 'badge--cyan' : 'badge--green' }}">
                {{ $user->role === 'admin' ? 'Administrador' : 'Usuario' }}
            </span>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,0.2);margin-top:10px">
            Miembro desde {{ date('d/m/Y', strtotime($user->created_at)) }}
        </div>
    </div>

    {{-- Editar nombre --}}
    <div class="card" style="padding:24px;margin-bottom:24px">
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
            <i class="fa-solid fa-pen" style="color:#00f5d4;margin-right:6px"></i> Información personal
        </div>
        <form method="POST" action="/perfil">
            <div style="margin-bottom:16px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                    onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
            </div>
            <div style="margin-bottom:16px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.05);background:rgba(255,255,255,0.01);color:rgba(255,255,255,0.3);font-size:14px;cursor:not-allowed">
            </div>
            <button type="submit" class="btn btn--ghost" style="font-size:12px">
                <i class="fa-solid fa-check"></i> Guardar cambios
            </button>
        </form>
    </div>

    {{-- Cambiar contraseña --}}
    <div class="card" style="padding:24px;margin-bottom:24px">
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
            <i class="fa-solid fa-lock" style="color:#ff6b9d;margin-right:6px"></i> Cambiar contraseña
        </div>
        <form method="POST" action="/perfil/password">
            <div style="margin-bottom:14px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Contraseña actual</label>
                <input type="password" name="current_password" required placeholder="••••••••"
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                    onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
            </div>
            <div style="margin-bottom:14px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Nueva contraseña</label>
                <input type="password" name="new_password" required placeholder="Mínimo 6 caracteres"
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                    onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
            </div>
            <div style="margin-bottom:20px">
                <label style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.4);display:block;margin-bottom:6px">Confirmar nueva contraseña</label>
                <input type="password" name="confirm_password" required placeholder="Repetí la nueva contraseña"
                    style="width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#fff;font-size:14px;outline:none;transition:border-color 0.3s"
                    onfocus="this.style.borderColor='rgba(0,245,212,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
            </div>
            <button type="submit" class="btn btn--ghost" style="font-size:12px;border-color:rgba(255,107,157,0.15);color:#ff6b9d">
                <i class="fa-solid fa-key"></i> Actualizar contraseña
            </button>
        </form>
    </div>

    {{-- Logros y medallas (Próximamente) --}}
    <div class="card" style="padding:24px;position:relative;overflow:hidden">
        <div style="position:absolute;inset:0;background:rgba(6,6,15,0.6);backdrop-filter:blur(3px);z-index:2;display:flex;flex-direction:column;align-items:center;justify-content:center;border-radius:16px">
            <div style="padding:6px 16px;border-radius:999px;background:rgba(123,97,255,0.15);border:1px solid rgba(123,97,255,0.25);font-size:11px;font-weight:600;color:#7b61ff;margin-bottom:8px">
                <i class="fa-solid fa-wand-magic-sparkles" style="margin-right:4px"></i> Próximamente
            </div>
            <div style="font-size:13px;color:rgba(255,255,255,0.4)">Ganá medallas por usar la app</div>
        </div>
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);margin-bottom:16px">
            <i class="fa-solid fa-trophy" style="color:#ffd166;margin-right:6px"></i> Logros y Medallas
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
            <div class="badge-achieve unlocked">
                <div class="badge-icon">📷</div>
                <div class="badge-name">Primer Escaneo</div>
                <div class="badge-desc">Subiste tu primera factura</div>
            </div>
            <div class="badge-achieve unlocked">
                <div class="badge-icon">🔍</div>
                <div class="badge-name">Cazador de Ofertas</div>
                <div class="badge-desc">Escaneaste 5 facturas</div>
            </div>
            <div class="badge-achieve unlocked">
                <div class="badge-icon">🏆</div>
                <div class="badge-name">Auditor Maestro</div>
                <div class="badge-desc">Ahorraste más de $10</div>
            </div>
            <div class="badge-achieve unlocked">
                <div class="badge-icon">🔥</div>
                <div class="badge-name">Frecuente</div>
                <div class="badge-desc">10 facturas procesadas</div>
            </div>
            <div class="badge-achieve locked">
                <div class="badge-icon">🐷</div>
                <div class="badge-name">Ahorrador Pro</div>
                <div class="badge-desc">Ahorraste más de $50</div>
            </div>
            <div class="badge-achieve locked">
                <div class="badge-icon">🎓</div>
                <div class="badge-name">Experto en Precios</div>
                <div class="badge-desc">25 facturas procesadas</div>
            </div>
            <div class="badge-achieve locked">
                <div class="badge-icon">👑</div>
                <div class="badge-name">Leyenda</div>
                <div class="badge-desc">100 facturas procesadas</div>
            </div>
            <div class="badge-achieve locked">
                <div class="badge-icon">📢</div>
                <div class="badge-name">Comunidad</div>
                <div class="badge-desc">Compartiste un ranking</div>
            </div>
        </div>
    </div>
</div>
@endsection
