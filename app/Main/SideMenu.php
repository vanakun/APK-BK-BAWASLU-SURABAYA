<?php

namespace App\Main;

class SideMenu
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
                'title' => 'Dashboard',
                        'route_name' => 'adminDashboard',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Dashboard'
                    ],
            'Jurnal' => [
                        'icon' => 'box',
                        'title' => 'Project',
                                'route_name' => 'indexAntrian',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Antrian Aduan'
                            ],
            'Setting Pemilihan' => [
                                'icon' => 'user',
                                'title' => 'Regis',
                                    'route_name' => 'SettingPemilihan',
                                        'params' => [
                                            'layout' => 'side-menu'
                                        ],
                                        'title' => 'Setting Aduan'
                                    ],
            'Setting Tahun Pemilihan' => [
                                    'icon' => 'box',
                                    'title' => 'Setting Tahun Pemilihan',
                                            'route_name' => 'SettingTahunPemilihan',
                                            'params' => [
                                                'layout' => 'side-menu'
                                            ],
                                            'title' => 'Setting Tahun Aduan'
                                        ],
        ];
    }
}
