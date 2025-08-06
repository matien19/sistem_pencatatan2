<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SI Tagihan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->nama ?? '' ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            $userRole = Yii::$app->user->identity->role ?? '';
            $menuItems = [];
            if ($userRole == 'admin' || $userRole == 'staf' ) {
                $menuItems = [
                    ['label' => 'Beranda', 'icon' => 'tachometer-alt', 'url' => ['beranda/index']],
                    [
                        'label' => 'Tagihan', 
                        'icon' => 'file-invoice-dollar', 
                        'url' => ['tagihan/index'],
                        'active' => Yii::$app->controller->id === 'tagihan',
                    ],
                ];

                if ($userRole == 'admin') {
                    $menuItems[] = [
                        'label' => 'Master Data',
                        'icon' => 'database',
                        'items' => [
                            [
                                'label' => 'Jurusan',
                                'iconStyle' => 'far',
                                'url' => ['jurusan/index'],
                                'active' => Yii::$app->controller->id === 'jurusan',
                            ],
                            [
                                'label' => 'Kelas',
                                'iconStyle' => 'far',
                                'url' => ['kelas/index'],
                                'active' => Yii::$app->controller->id === 'kelas',
                            ],
                            // [
                            //     'label' => 'Calon Siswa',
                            //     'iconStyle' => 'far',
                            //     'url' => ['calon-siswa/index'],
                            //     'active' => Yii::$app->controller->id === 'calon-siswa',
                            // ],
                            [
                                'label' => 'Siswa',
                                'iconStyle' => 'far',
                                'url' => ['siswa/index'],
                                'active' => Yii::$app->controller->id === 'siswa' || Yii::$app->controller->id === 'calon-siswa',
                            ],
                            [
                                'label' => 'Staf',
                                'iconStyle' => 'far',
                                'url' => ['staf/index'],
                                'active' => Yii::$app->controller->id === 'staf',
                            ],
                            [
                                'label' => 'Nama Pembayaran',
                                'iconStyle' => 'far',
                                'url' => ['nama-pembayaran/index'],
                                'active' => Yii::$app->controller->id === 'nama-pembayaran',
                            ],
                            [
                                'label' => 'Jenis Pembayaran',
                                'iconStyle' => 'far',
                                'url' => ['jenis-pembayaran/index'],
                                'active' => Yii::$app->controller->id === 'jenis-pembayaran',
                            ],
                        ],
                    ];
                    $menuItems[] = [
                        'label' => 'Laporan',
                        'iconStyle' => 'fas fa-clipboard',
                        'url' => ['laporan/index'],
                        'active' => Yii::$app->controller->id === 'laporan',
                    ];
                }
 
            } else {
                $menuItems = [
                    ['label' => 'Beranda', 'icon' => 'tachometer-alt', 'url' => ['beranda/siswa']],
                    [
                        'label' => 'Tagihan', 
                        'icon' => 'file-invoice-dollar', 
                        'url' => ['tagihan-siswa/index'],
                        'active' => Yii::$app->controller->id === 'tagihan-siswa',
                    ],
                        
                ];
                
            }

            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $menuItems,
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>