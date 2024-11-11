const MenuArray = [
    {
        'label': 'Mi espacio',
        'options': [
            {
                'href': 'dashboard',
                'icon': 'mdi mdi-desktop-mac',
                'name': 'Inicio',
                'permiso': 'HOME',
            },
            {
                'href': 'profile.edit',
                'icon': 'mdi mdi-account-circle',
                'name': 'Mi Perfil',
                'permiso': 'HOME'
            }
        ]
    },
    {
        'label': 'Unidades',
        'options': [
            {
                'href': 'units.view',
                'icon': 'mdi mdi-qrcode',
                'name': 'QR Unidades',
                'permiso': 'VIEW_UNITS_CODES'
            }
        ]
    },
    {
        'label': 'Reportes',
        'options': [
            {
                'href': 'dispatch.view',
                'icon': 'mdi mdi-file',
                'name': 'Hojas de despacho',
                'permiso': 'VIEW_DISPATCH_SHEET'
            }
        ]
    }
];

export default MenuArray;