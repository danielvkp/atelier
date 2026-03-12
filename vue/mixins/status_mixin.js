export const status_mixin = {
    data() {
        return {
            estado_mudanza: [
                'Pendiente',
                'Completado',
            ],
            tamanos: [
                'Pequeño',
                'Mediano',
                'Grande'
            ],
            tipos_medios: [
                'Interno',
                'Externo'
            ],
            medios_internos: [
                'MGM',
                'WEB',
                'WA',
                'TLF',
                'P',
                'ELE',
                'COLA',
                'PUBLI'
            ],
            medios_externos: [
                'M24',
                'BAM',
                'ZK',
                'MONL',
                'IM'
            ],
            seguimiento: [
                'Nuevo',
                'Contactado',
                'Presupuesto enviado',
                'Cerrado'
            ],
        }
    }
}