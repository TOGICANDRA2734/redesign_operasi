<?php

namespace App\Main;

class SideMenuUser
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
                'route_name' => 'user.dashboard',
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
                        'route_name' => 'user.data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'laporan-productivity' => [
                        'icon' => 'box',
                        'title' => 'Laporan Productivity',
                        'route_name' => 'user.productivity.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    
                    'laporan-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'user.productivity_coal.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'laporan-kendala' => [
                        'icon' => 'box',
                        'title' => 'Laporan Kendala',
                        'route_name' => 'user.kendala.index',
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
                        'route_name' => 'mohh.index',
                    ],
                    
                    'rep-harian' => [
                        'icon' => 'box',
                        'title' => 'Report Harian',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'route_name' => 'rep.index',
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
                        'route_name' => 'user.transferPma.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
        ];
    }
}
