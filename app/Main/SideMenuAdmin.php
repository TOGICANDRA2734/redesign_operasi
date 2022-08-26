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
        if (Auth::user()->kodesite !== 'X') {
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
            ];
        } else {
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
            ];
        }
    }
}
