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
                    'transaksi-invoice' => [
                        'icon' => 'inbox',
                        'route_name' => 'invoice.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Invoice'
                    ],
                    'transaksi-joint-survey' => [
                        'icon' => 'inbox',
                        'route_name' => 'joint-survey.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Joint Survey'
                    ],
                    'transaksi-budget' => [
                        'icon' => 'inbox',
                        'route_name' => 'budget.create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Budget'
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
                        'route_name' => 'data-prod.report',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'laporan-productivity' => [
                        'icon' => 'box',
                        'title' => 'Laporan Productivity',
                        'route_name' => 'productivity.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    
                    'laporan-produksi-coal' => [
                        'icon' => 'inbox',
                        'route_name' => 'productivity_coal.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Ritasi Coal'
                    ],
                    'laporan-kendala' => [
                        'icon' => 'box',
                        'title' => 'Laporan Kendala',
                        'route_name' => 'kendala.index',
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
                                'route_name' => 'mohh-harian.index',
                            ],
                            'rep-harian' => [
                                'icon' => 'box',
                                'title' => 'Report Harian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'rep.index',
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
                            'cost-part-tipe' => [
                                'icon' => 'box',
                                'title' => 'Cost Part Per Tipe Unit',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'cost-part-tipe.index',
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
                            'populasi-do' => [
                                'icon' => 'box',
                                'title' => 'Populasi DO',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'populasi-do.index',
                            ],
                            'versatility' => [
                                'icon' => 'box',
                                'title' => 'Versatility',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'versatility.index',
                            ],
                            'distance-harian' => [
                                'icon' => 'box',
                                'title' => 'Distance Harian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'distance-harian.index',
                            ],
                            'distance-bulanan' => [
                                'icon' => 'box',
                                'title' => 'Distance Bulanan',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'distance-bulanan.index',
                            ],
                            'tp-pty-nom' => [
                                'icon' => 'box',
                                'title' => 'PTY Per Nomor Unit (TP)',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'tp-pty-nom.index',
                            ],
                            'tp-pty-tipe' => [
                                'icon' => 'box',
                                'title' => 'PTY per Tipe Unit (TP)',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'tp-pty-tipe.index',
                            ],
                            'a2b-pty-nom' => [
                                'icon' => 'box',
                                'title' => 'PTY per Nomor Unit (A2B)',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'a2b-pty-nom.index',
                            ],
                            'a2b-pty-tipe' => [
                                'icon' => 'box',
                                'title' => 'PTY per Tipe Unit (A2B)',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'a2b-pty-tipe.index',
                            ],
                            'fleet-setting' => [
                                'icon' => 'box',
                                'title' => 'Fleet Setting',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'fleet-setting.index',
                            ],
                            'solar-in-trans' => [
                                'icon' => 'box',
                                'title' => 'Solar versi In Trans',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'solar-in-trans.index',
                            ],
                            'solar-opname' => [
                                'icon' => 'box',
                                'title' => 'Solar Stock (Solar Opname)',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'solar-opname.index',
                            ],
                            'solar-intrans-vs-rssp' => [
                                'icon' => 'box',
                                'title' => 'Solar In Trans VS RS',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'solar-in-trans-rssp.index',
                            ],
                        ],
                    ],
                    'Testing' => [
                        'icon' => 'sidebar',
                        'title' => 'Testing',
                        'sub_menu' => [
                            'distribusi-tp' => [
                                'icon' => 'box',
                                'title' => 'Distribusi Jam TP',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'hours-distribution-tp.index',
                            ],
                            'distribusi-a2b' => [
                                'icon' => 'box',
                                'title' => 'Distribusi Jam A2B',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'hours-distribution-a2b.index',
                            ],
                            'ma-bulanan' => [
                                'icon' => 'box',
                                'title' => 'MA Bulanan',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'ma-bulanan.index',
                            ],
                            'ma-harian' => [
                                'icon' => 'box',
                                'title' => 'MA Harian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'ma-harian.index',
                            ],
                            'pty-tp' => [
                                'icon' => 'box',
                                'title' => 'Productivity TP',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'pty-tp.index',
                            ],
                            'pty-a2b' => [
                                'icon' => 'box',
                                'title' => 'Productivity A2B',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'pty-a2b.index',
                            ],

                            
                            'invoice-joint-survey' => [
                                'icon' => 'box',
                                'title' => 'Produksi Invoice Joint Survey',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'invoice-joint-survey.index',
                            ],
                            'customer-joint-survey' => [
                                'icon' => 'box',
                                'title' => 'Produksi Target Customer Joint Survey',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'customer-joint-survey.index',
                            ],
                            'tc-pma' => [
                                'icon' => 'box',
                                'title' => 'Produksi Truck Count PMA',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'tc-pma.index',
                            ],
                            'produksi-ob-per-pit-pma' => [
                                'icon' => 'box',
                                'title' => 'Produksi OB Per Pit PMA',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'produksi-ob-per-pit-pma.index',
                            ],
                            'produksi-ob-tc-pma' => [
                                'icon' => 'box',
                                'title' => 'Produksi OB Truck Count PMA',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'produksi-ob-tc-pma.index',
                            ],
                            'Fuel-unit-bulanan' => [
                                'icon' => 'box',
                                'title' => 'Fuel Unit Bulanan',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'Fuel-unit-bulanan.index',
                            ],
                            'Fuel-unit-harian' => [
                                'icon' => 'box',
                                'title' => 'Fuel Unit Harian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'Fuel-unit-harian.index',
                            ],
                            'Fuel-unit-per-bulanan' => [
                                'icon' => 'box',
                                'title' => 'Fuel Unit Per Bulan',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'Fuel-unit-per-bulanan.index',
                            ],
                            'Fuel-unit-periode' => [
                                'icon' => 'box',
                                'title' => 'Fuel Unit Periode',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'Fuel-unit-periode.index',
                            ],

                            'cost-unit' => [
                                'icon' => 'box',
                                'title' => 'Cost Unit',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'cost-unit.index',
                            ],
                            'mohh' => [
                                'icon' => 'box',
                                'title' => 'MOHH',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'mohh.index',
                            ],
                            'rain-slip' => [
                                'icon' => 'box',
                                'title' => 'Rain Slip',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'route_name' => 'rain-slip.index',
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
                    
                    'spare-part-rssp' => [
                        'icon' => 'box',
                        'title' => 'Spare Part RSSP',
                        'route_name' => 'spare-part-rssp.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    
                    'spare-part-in-trans' => [
                        'icon' => 'box',
                        'title' => 'Spare Part In Trans',
                        'route_name' => 'spare-part-in-trans.index',
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
                        'route_name' => 'mp.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'kontrak' => [
                        'icon' => 'box',
                        'title' => 'Kontrak',
                        'route_name' => 'mp-kontrak.index',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'statistik' => [
                        'icon' => 'box',
                        'title' => 'Statistik',
                        'route_name' => 'mp-statistik.index',
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
