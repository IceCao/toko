<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex text-uppercase">
            <div class="info w-100 text-center">
                <a href="#" class="d-block"><?php echo $this->session->userdata('nama') ?></a>
            </div>
        </div>

        <div class="form-inline">
            <!-- <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div> -->
        </div>
        <?php 
            $sidebar = [];
            if($this->session->userdata('role') == 'admin'){
                $sidebar = [
                    [
                        'type' => 'single',
                        'url' => 'dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'label' => 'Dashboard',
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-database',
                        'label' => 'Master',
                        'items' => [
                            ['url' => 'gudang', 'label' => 'Gudang'],
                            ['url' => 'kategori', 'label' => 'Kategori'],
                            ['url' => 'subkategori', 'label' => 'Sub Kategori'],
                            ['url' => 'hargajual', 'label' => 'Setting Harga Jual'],
                            ['url' => 'users', 'label' => 'Users'],
                        ]
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-cash-register',
                        'label' => 'Barang Masuk',
                        'items' => [
                            ['url' => 'pembelian', 'label' => 'Pembelian'],
                        ]
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-file-export',
                        'label' => 'Barang Keluar',
                        'items' => [
                            ['url' => 'penjualan', 'label' => 'Penjualan'],
                            ['url' => 'pengembalian', 'label' => 'Return'],
                        ]
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-receipt',
                        'label' => 'Report',
                        'items' => [
                            ['url' => 'report_laba', 'label' => 'Laba'],
                            ['url' => 'report_barang', 'label' => 'Gudang'],
                        ]
                    ],
                ];
            } elseif($this->session->userdata('role') == 'kasir'){
                $sidebar = [
                    [
                        'type' => 'single',
                        'url' => 'dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'label' => 'Dashboard',
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-cash-register',
                        'label' => 'Barang Masuk',
                        'items' => [
                            ['url' => 'pembelian', 'label' => 'Pembelian'],
                        ]
                    ],
                    [
                        'type' => 'multi',
                        'icon' => 'fas fa-file-export',
                        'label' => 'Barang Keluar',
                        'items' => [
                            ['url' => 'penjualan', 'label' => 'Penjualan'],
                            ['url' => 'pengembalian', 'label' => 'Return'],
                        ]
                    ],
                ];
            }
        ?>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php foreach($sidebar as $menu): ?>
                    <?php if($menu['type'] == 'single'): ?>
                        <li class="nav-item">
                            <a href="<?= site_url($menu['url']) ?>" class="nav-link">
                                <i class="nav-icon <?= $menu['icon'] ?>"></i>
                                <p><?= $menu['label'] ?></p>
                            </a>
                        </li>
                    <?php elseif($menu['type'] == 'multi'): ?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon <?= $menu['icon'] ?>"></i>
                                <p>
                                    <?= $menu['label'] ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach($menu['items'] as $sub): ?>
                                    <li class="nav-item">
                                        <a href="<?= site_url($sub['url']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= $sub['label'] ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</aside>