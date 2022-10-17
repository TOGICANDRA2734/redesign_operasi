<?php

namespace App\Main;

class SideMenuSuperAdmin
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'super_admin.dashboard',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Dashboard'
            ],
            'devider',
            'transaksi' => [
                'icon' => 'hard-drive',
                'title' => 'Transaksi',
                'sub_menu' => [
                    'transaksi-actual' => [
                        'icon' => 'box',
                        'title' => 'Produksi Truck Count',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'super_admin.data-prod.index',
                    ],
                    'transaksi-produksi' => [
                        'icon' => 'inbox',
                        'route_name' => 'super_admin.productivity.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Productivity'
                    ],
                    
                    'transaksi-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'super_admin.productivity_coal.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'transaksi-kendala' => [
                        'icon' => 'inbox',
                        'route_name' => 'super_admin.kendala.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kendala'
                    ],
                ],
            ],
            'devider',
            'Laporan' => [
                'icon' => 'sidebar',
                'title' => 'Laporan',
                'sub_menu' => [
                    'laporan-actual' => [
                        'icon' => 'box',
                        'title' => 'Produksi Truck Count',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'laporan-productivity' => [
                        'icon' => 'box',
                        'title' => 'Laporan Productivity',
                        'route_name' => 'super_admin.productivity.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    
                    'laporan-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'super_admin.productivity_coal.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'laporan-kendala' => [
                        'icon' => 'box',
                        'title' => 'Laporan Kendala',
                        'route_name' => 'super_admin.kendala.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
            'devider',
            'Tools' => [
                'icon' => 'sidebar',
                'title' => 'Tools',
                'sub_menu' => [
                    'transaksi-pma' => [
                        'icon' => 'box',
                        'title' => 'Kirim Data PMA ke HO',
                        'route_name' => 'super_admin.transferPma.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'admin-transaksi-pma' => [
                        'icon' => 'box',
                        'title' => 'Admin PMA',
                        'route_name' => 'super_admin.adminTransaksiPma.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'log-data' => [
                        'icon' => 'box',
                        'title' => 'Log Data User',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    
                    'mohh-harian' => [
                        'icon' => 'box',
                        'title' => 'MOHH Harian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'super_admin.mohh.index',
                    ],
                    
                    'rep-harian' => [
                        'icon' => 'box',
                        'title' => 'Report Harian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'super_admin.rep.index',
                    ],
                ],
            ],
            'devider',
            'Status Breakdown' => [
                'icon' => 'sidebar',
                'title' => 'Plant',
                'sub_menu' => [
                    'breakdown-harian' => [
                        'icon' => 'box',
                        'title' => 'Status BD Harian',
                        'route_name' => 'super_admin.bd-harian.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'populasi-unit' => [
                        'icon' => 'box',
                        'title' => 'Populasi unit',
                        'route_name' => 'super_admin.populasi-unit.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'historical-repair' => [
                        'icon' => 'box',
                        'title' => 'Historical Repair',
                        'route_name' => 'super_admin.historical-unit.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'historical-overhaul' => [
                        'icon' => 'box',
                        'title' => 'Historical Overhaul',
                        'route_name' => 'super_admin.historical-overhaul.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'program-analisa-pelumasan' => [
                        'icon' => 'box',
                        'title' => 'Program Analisa Pelumas (PAP)',
                        'route_name' => 'super_admin.pap.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
            'devider',
            'Manpower' => [
                'icon' => 'sidebar',
                'title' => 'Manpower',
                'sub_menu' => [
                    'laporan-actual' => [
                        'icon' => 'box',
                        'title' => 'Table MP',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'kontrak' => [
                        'icon' => 'box',
                        'title' => 'Kontrak',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'tambah-data-mp' => [
                        'icon' => 'box',
                        'title' => 'Tambah Data MP',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'statistik' => [
                        'icon' => 'box',
                        'title' => 'Statistik',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'export-mp' => [
                        'icon' => 'box',
                        'title' => 'Export MP',
                        'route_name' => 'super_admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'general-request' => [
                        'icon' => 'box',
                        'title' => 'General Request',
                        'route_name' => 'super_admin.dokumen-gr.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
        ];
    }
}
