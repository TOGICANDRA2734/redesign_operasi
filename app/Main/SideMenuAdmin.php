<?php

namespace App\Main;

use Illuminate\Support\Facades\Auth;

class SideMenuAdmin
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
                'route_name' => 'admin.dashboard',
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
                        'route_name' => 'admin.data-prod.index',
                    ],
                    'transaksi-produksi' => [
                        'icon' => 'inbox',
                        'route_name' => 'admin.productivity.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Productivity'
                    ],
                    'transaksi-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'admin.productivity_coal.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'transaksi-kendala' => [
                        'icon' => 'inbox',
                        'route_name' => 'admin.kendala.create',
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
                        'route_name' => 'admin.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'laporan-productivity' => [
                        'icon' => 'box',
                        'title' => 'Productivity',
                        'route_name' => 'admin.productivity.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'laporan-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'admin.productivity_coal.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'laporan-kendala' => [
                        'icon' => 'box',
                        'title' => 'Kendala',
                        'route_name' => 'admin.kendala.index',
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
                        'route_name' => 'admin.transferPma.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
            'devider',
            'Transaksi Plant' => [
                'icon' => 'sidebar',
                'title' => 'Transaksi Plant',
                'sub_menu' => [
                    'breakdown-harian' => [
                        'icon' => 'box',
                        'title' => 'Status BD Harian',
                        'route_name' => 'bd-harian.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'populasi-unit' => [
                        'icon' => 'box',
                        'title' => 'Populasi unit',
                        'route_name' => 'populasi-unit.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'hm-unit' => [
                        'icon' => 'box',
                        'title' => 'HM Unit',
                        'route_name' => 'hm.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'historical-overhaul' => [
                        'icon' => 'box',
                        'title' => 'Historical Overhaul',
                        'route_name' => 'historical-overhaul.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'program-analisa-pelumasan' => [
                        'icon' => 'box',
                        'title' => 'Program Analisa Pelumas (PAP)',
                        'route_name' => 'pap.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
            'devider',
            'Laporan Plant' => [
                'icon' => 'sidebar',
                'title' => 'Laporan Plant',
                'sub_menu' => [
                    'breakdown-harian' => [
                        'icon' => 'box',
                        'title' => 'Status BD Harian',
                        'route_name' => 'bd-harian.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'populasi-unit' => [
                        'icon' => 'box',
                        'title' => 'Populasi unit',
                        'route_name' => 'populasi-unit.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'historical-repair' => [
                        'icon' => 'box',
                        'title' => 'Historical Repair',
                        'route_name' => 'historical-unit.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'historical-overhaul' => [
                        'icon' => 'box',
                        'title' => 'Historical Overhaul',
                        'route_name' => 'historical-overhaul.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'program-analisa-pelumasan' => [
                        'icon' => 'box',
                        'title' => 'Program Analisa Pelumas (PAP)',
                        'route_name' => 'pap.index',
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
                    'general-request' => [
                        'icon' => 'box',
                        'title' => 'General Request',
                        'route_name' => 'dokumen-gr.index',
                        'params' => [ 
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
        ];
    }
}
