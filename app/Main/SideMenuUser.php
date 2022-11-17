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
                    'PMA' => [
                        'icon' => 'sidebar',
                        'title' => 'PMA',
                        'sub_menu' => [
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
                            'daily-produksi' => [
                                'icon' => 'box',
                                'title' => 'Laporan Harian Truck Count PMA',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'daily-production.index',
                            ],
                            'monthly-produksi' => [
                                'icon' => 'box',
                                'title' => 'Laporan Bulanan Truck Count PMA',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'monthly-production.index',
                            ],
                            'fuel-daily' => [
                                'icon' => 'box',
                                'title' => 'Laporan Solar Harian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'fuel-daily.index',
                            ],
                            'fuel-unit' => [
                                'icon' => 'box',
                                'title' => 'Laporan Solar Unit',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'fuel-unit.index',
                            ],
                            'cost-part' => [
                                'icon' => 'box',
                                'title' => 'Cost Part',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'cost-part.index',
                            ],
                            'laporan-bulanan-budget' => [
                                'icon' => 'box',
                                'title' => 'Produksi Bulanan',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'laporan-bulanan.index',
                            ],
                            'laporan-bulanan-target-customer' => [
                                'icon' => 'box',
                                'title' => 'Produksi Bulanan Customer',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'laporan-customer.index',
                            ],
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
                        'route_name' => 'user.transferPma.index',
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
