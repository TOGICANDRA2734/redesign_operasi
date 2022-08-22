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
                        'title' => 'Laporan Actual',
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
                    'laporan-kendala' => [
                        'icon' => 'box',
                        'title' => 'Laporan Kendala',
                        'route_name' => 'user.kendala.index',
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
                        'title' => 'Kirim Data PMA',
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
