
<style>
    /* Adaptar colores con variables CSS */
    .ajustes-container {
        color: var(--text-color);
    }
    .card-ajuste {
        background-color: var(--bg-fondo2);
        border: 1px solid var(--color-temp);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        transition: background-color 0.3s, border-color 0.3s;
        height: 100%;
    }
    .card-ajuste h5 {
        color: var(--color-primario);
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .form-check-label {
        color: var(--text-color);
        font-weight: 600;
    }
    .form-select {
        background-color: var(--bg-fondo);
        color: var(--text-color);
        border-color: var(--color-temp);
        transition: background-color 0.3s, border-color 0.3s, color 0.3s;
    }
    .form-select:focus {
        border-color: var(--color-primario);
        box-shadow: 0 0 0 0.25rem rgba(105, 122, 254, 0.25);
    }
</style>

<div class="container ajustes-container mt-4">
    <h2 class="mb-4">Ajustes del usuario</h2>
    <form action="{{ route('ajustes.guardar') }}" method="POST">
        @csrf
        
        <div class="row g-4">

            <!-- Preferencias Generales -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-ajuste">
                    <h5>Preferencias Generales</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="notificaciones" id="notificaciones"
                            {{ old('notificaciones', $ajustes->notificaciones ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notificaciones">Activar notificaciones</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="activar_sonidos" id="activar_sonidos"
                            {{ old('activar_sonidos', $ajustes->activar_sonidos ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activar_sonidos">Activar sonidos</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="recordar_sesion" id="recordar_sesion"
                            {{ old('recordar_sesion', $ajustes->recordar_sesion ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="recordar_sesion">Recordar sesión</label>
                    </div>
                </div>
            </div>

            <!-- Apariencia y Tema -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-ajuste">
                    <h5>Apariencia y Tema</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="modo_oscuro" id="modo_oscuro"
                            {{ old('modo_oscuro', $ajustes->modo_oscuro ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="modo_oscuro">Usar modo oscuro</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="animaciones" id="animaciones"
                            {{ old('animaciones', $ajustes->animaciones ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="animaciones">Mostrar animaciones</label>
                    </div>

                    <div class="mb-3">
                        <label for="tema_color" class="form-label">Tema de color</label>
                        <select class="form-select" name="tema_color" id="tema_color">
                            <option value="default" {{ (old('tema_color', $ajustes->tema_color ?? '') == 'default') ? 'selected' : '' }}>Predeterminado</option>
                            <option value="blue" {{ (old('tema_color', $ajustes->tema_color ?? '') == 'blue') ? 'selected' : '' }}>Azul</option>
                            <option value="green" {{ (old('tema_color', $ajustes->tema_color ?? '') == 'green') ? 'selected' : '' }}>Verde</option>
                            <option value="red" {{ (old('tema_color', $ajustes->tema_color ?? '') == 'red') ? 'selected' : '' }}>Rojo</option>
                            <option value="purple" {{ (old('tema_color', $ajustes->tema_color ?? '') == 'purple') ? 'selected' : '' }}>Púrpura</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Menús y Navegación -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-ajuste">
                    <h5>Menús y Navegación</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="mantener_submenus" id="mantener_submenus"
                            {{ old('mantener_submenus', $ajustes->mantener_submenus ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mantener_submenus">Mantener submenús abiertos</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="scroll_suave" id="scroll_suave"
                            {{ old('scroll_suave', $ajustes->scroll_suave ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="scroll_suave">Desplazamiento suave</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="mostrar_tooltips" id="mostrar_tooltips"
                            {{ old('mostrar_tooltips', $ajustes->mostrar_tooltips ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mostrar_tooltips">Mostrar tooltips</label>
                    </div>
                </div>
            </div>

            <!-- Seguridad y Privacidad -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-ajuste">
                    <h5>Seguridad y Privacidad</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="autenticacion_2fa" id="autenticacion_2fa"
                            {{ old('autenticacion_2fa', $ajustes->autenticacion_2fa ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="autenticacion_2fa">Autenticación 2FA</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="alertas_email" id="alertas_email"
                            {{ old('alertas_email', $ajustes->alertas_email ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="alertas_email">Alertas por email</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="registro_actividad" id="registro_actividad"
                            {{ old('registro_actividad', $ajustes->registro_actividad ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="registro_actividad">Registro de actividad</label>
                    </div>
                </div>
            </div>

            <!-- Otros Ajustes -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-ajuste">
                    <h5>Otros Ajustes</h5>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="mostrar_avatar" id="mostrar_avatar"
                            {{ old('mostrar_avatar', $ajustes->mostrar_avatar ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mostrar_avatar">Mostrar avatar de usuario</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="recibir_newsletter" id="recibir_newsletter"
                            {{ old('recibir_newsletter', $ajustes->recibir_newsletter ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="recibir_newsletter">Recibir newsletter</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="mostrar_consejos" id="mostrar_consejos"
                            {{ old('mostrar_consejos', $ajustes->mostrar_consejos ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="mostrar_consejos">Mostrar consejos útiles</label>
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>
</div>
