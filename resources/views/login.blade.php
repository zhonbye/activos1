@extends('layout')

@section('title', 'Iniciar Sesión')

@section('styles')
<style>
       body {
            /* background: url("{{ asset('img/hwk.jpg') }}") no-repeat center center fixed; */
            /* background-size: cover;
            min-height: 100vh;
            height: 100vh;
            max-height: 100vh;
            padding: 0px;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--color-texto-principal);
            overflow-x: hidden;
            min-width: 0;
            max-height: 50vh; */
        }
    .card-login {
        width: var(--ancho-tarjeta);
        border-radius: var(--border-radius-tarjeta);
        border: 2px solid var(--tarjeta-borde-color);
        background: var(--color-tarjeta-fondo);
        padding: 2rem;
        box-sizing: border-box;
    }

    .titulo-login {
        color: var(--color-texto-principal);
        font-weight: var(--font-weight-titulo);
        font-size: var(--font-size-titulo);
        text-align: center;
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--tarjeta-borde-color);
        padding-bottom: 0.5rem;
        user-select: none;
    }

    .form-control-login {
        background: var(--color-input-fondo);
        color: var(--color-input-texto);
        border: 1.5px solid var(--color-input-borde-led);
        border-radius: 6px;
        padding-left: 0.8rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control-login::placeholder {
        color: var(--color-input-placeholder);
    }

    .form-control-login:focus {
        background: var(--color-input-fondo);
        color: var(--color-input-texto);
        border-color: var(--color-link);
        outline: none;
        box-shadow: none;
    }

    .btn-login {
        background-color: var(--color-boton-fondo);
        color: var(--color-boton-texto);
        font-size: 1.2rem;
        font-weight: 600;
        padding: 0.7rem 0;
        border: none;
        border-radius: 6px;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease;
        user-select: none;
    }

    .btn-login:hover,
    .btn-login:focus {
        background-color: var(--color-link-hover);
        color: var(--color-boton-texto);
    }

    .form-check-label {
        color: var(--color-texto-principal);
        user-select: none;
    }

    .link-olvide {
        color: var(--color-link);
        font-weight: 500;
        text-decoration: none;
        user-select: none;
    }

    .link-olvide:hover {
        color: var(--color-link-hover);
    }

    .form-check-input {
        border-color: var(--color-input-borde-led);
        cursor: pointer;
    }
</style>
@endsection

@section('contenido')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card-login">
        <h2 class="titulo-login">Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}" novalidate id="loginForm">
            @csrf

            <div class="mb-4">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" id="usuario" name="usuario" required autofocus
                    class="form-control form-control-login @error('usuario') is-invalid @enderror"
                    placeholder="Ingrese su usuario" value="{{ old('usuario') }}">
                @error('usuario')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" id="clave" name="clave" required
                    class="form-control form-control-login @error('clave') is-invalid @enderror"
                    placeholder="Ingrese su contraseña">
                @error('clave')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-login">
                Entrar
            </button>

            <div class="mt-3 text-center">
                <a href="#" class="link-olvide">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
            <div id="errorGeneral" style="color: red; margin-top: 1rem;"></div>
        </form>
    </div>
</div>
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const form = document.querySelector('form'); // o usa el id si quieres: document.getElementById('miFormulario')

    //     form.addEventListener('submit', function () {
    //         // Esperamos un poco antes de limpiar para asegurarnos que el envío ocurrió
    //         setTimeout(() => {
    //             form.reset(); // Limpia todos los campos del formulario
    //         }, 300); // 300ms es suficiente para que se procese la solicitud
    //     });
    // });
//     document.getElementById('loginForm').addEventListener('submit', function(e) {
//     if (!this.checkValidity()) {
//         // Si no es válido, dejar que el navegador muestre errores nativos
//         return; // no hacemos preventDefault para que navegador muestre mensajes
//     }
//     e.preventDefault(); // formulario válido, evitar recarga para ajax

//     const formData = new FormData(this);
//     const token = formData.get('_token');

//     fetch("{{ route('login') }}", {
//     method: 'POST',
//     headers: {
//         'X-CSRF-TOKEN': token,
//         'Accept': 'application/json',
//     },
//     body: formData
// })
//     .then(async response => {
//         if (response.ok) {
//             window.location.href = "{{ url('/dashboard') }}";
//         } else {
//             const data = await response.json();
//             // limpiar errores previos
//             document.getElementById('errorUsuario').textContent = '';
//             document.getElementById('errorClave').textContent = '';
//             document.getElementById('errorGeneral').textContent = '';

//             if (data.errors) {
//                 if (data.errors.usuario) document.getElementById('errorUsuario').textContent = data.errors.usuario[0];
//                 if (data.errors.clave) document.getElementById('errorClave').textContent = data.errors.clave[0];
//             }
//             if (data.message) {
//                 document.getElementById('errorGeneral').textContent = data.message;
//             }
//         }
//     })
//     .catch(() => {
//         document.getElementById('errorGeneral').textContent = 'Error en la conexión.';
//     });
// });

</script>


@endsection
