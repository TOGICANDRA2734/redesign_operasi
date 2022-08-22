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
                        'title' => 'Transaksi Actual',
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
                        'title' => 'Transaksi Productivity'
                    ],
                    'transaksi-kendala' => [
                        'icon' => 'inbox',
                        'route_name' => 'super_admin.kendala.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Transaksi Kendala'
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
                        'title' => 'Laporan Actual',
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
                        'title' => 'Kirim Data PMA',
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
                ],
            ],
        ];
    }
}
