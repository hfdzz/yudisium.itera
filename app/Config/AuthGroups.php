<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user_mahasiswa';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'user_mahasiswa' => [
            'title'       => 'User Mahasiswa',
            'description' => 'Mahasiswa ITERA.', // For now, only Mahasiswa FTI
        ],
        'user_fakultas' => [
            'title'       => 'User Fakultas',
            'description' => 'Fakultas ITERA.', // For now, only Fakultas FTI
        ],
        'user_upt_perpustakaan' => [
            'title'       => 'User UPT Perpustakaan',
            'description' => 'UPT Perpustakaan ITERA.',
        ],
        'user_keuangan' => [
            'title'       => 'User Keuangan',
            'description' => 'Keuangan ITERA.',
        ],
        // 'developer' => [
        //     'title'       => 'Developer',
        //     'description' => 'Site programmers.',
        // ],
        // 'user' => [
        //     'title'       => 'User',
        //     'description' => 'General users of the site. Often customers.',
        // ],
        // 'beta' => [
        //     'title'       => 'Beta User',
        //     'description' => 'Has access to beta-level features.',
        // ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.access'        => 'Can access the sites admin area',
        'admin.settings'      => 'Can access the main site settings',
        'users.manage-admins' => 'Can manage other admins',
        'users.create'        => 'Can create new non-admin users',
        'users.edit'          => 'Can edit existing non-admin users',
        'users.delete'        => 'Can delete existing non-admin users',
        'beta.access'         => 'Can access beta-level features',

        // Yudisium
        'mahasiswa.daftar_yudisium' => 'Can daftar yudisium',
        'fakultas.validasi_yudisium' => 'Can validasi yudisium',
        
        // SK Bebas Perpustakaan
        'mahasiswa.mengajukan_sk_bebas_perpustakaan' => 'Can mengajukan SK Bebas Perpustakaan',
        'upt_perpustakaan.validasi_sk_bebas_perpustakaan' => 'Can validasi SK Bebas Perpustakaan',

        // SK Bebas UKT
        'mahasiswa.mengajukan_sk_bebas_ukt' => 'Can mengajukan SK Bebas UKT',
        'keuangan.validasi_sk_bebas_ukt' => 'Can validasi SK Bebas UKT',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'users.*',
            // 'beta.*',
        ],
        'admin' => [
            'admin.access',
            'users.create',
            'users.edit',
            'users.delete',
            // 'beta.access',
        ],
        // 'user' => [],
        'user_mahasiswa' => [
            'mahasiswa.*',
            'mahasiswa.daftar_yudisium',
        ],
        'user_fakultas' => [
            'fakultas.*'
        ],
        'user_upt_perpustakaan' => [
            'upt_perpustakaan.*'
        ],
        'user_keuangan' => [
            'keuangan.*'
        ],
        // 'developer' => [
        //     'admin.access',
        //     'admin.settings',
        //     'users.create',
        //     'users.edit',
        //     'beta.access',
        // ],
        // 'beta' => [
        //     'beta.access',
        // ],
    ];
}
