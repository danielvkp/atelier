export const usuario_rules = {
    data() {
        return {
            valid: true,
            nombre_rules: [
                v => !!v || 'Requerido',
                v => (v && v.length <= 60) || 'Supera el limite',
            ],
            email_rules: [
                v => !!v || 'Requerido',
                v => /.+@.+\..+/.test(v) || 'E-mail debe ser valido',
            ],
            password_rules: [
                v => !!v || 'Requerido',
                v => (v && v.length >= 8) || 'Min 8 caracteres',
            ],
            dumb_password_rules: [
                v => !!v || 'Requerido',
                v => (v && v.length >= 8) || 'Min 8 caracteres',
                v => (v && v != 'dummy-password') || 'Cambiar contraseña',
            ],
            dni_rules: [
                v => (!v || v.length == 8) || '8 Caracteres',
            ],
            celular_rules: [
                v => (!v || v.length == 9) || '9 Caracteres',
            ],
            ident_rules: [
                v => !!v || 'Requerido',
            ],
            role_rules: [
                v => !!v || 'Requerido',
            ],
            size_rules: [
                v => !!v || 'Requerido',
            ],
            test_rules: {
                password_rules: [
                    v => !!v || 'Requerido',
                    v => (v && v.length >= 8) || 'Min 8 caracteres',
                ],
                dumb_password_rules: [
                    v => !!v || 'Requerido',
                    v => (v && v.length >= 8) || 'Min 8 caracteres',
                    v => (v && v != 'dummy-password') || 'Cambiar contraseña',
                ],
            }
        }
    },
}