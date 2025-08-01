<?php
use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Beranda';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <p>Selamat datang, Admin! Berikut adalah ringkasan data sistem:</p>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5><?= $jumlahSiswa ?> Siswa</h5>
                            <p>Siswa aktif terdaftar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5><?= $jumlahCalon ?> Calon Siswa</h5>
                            <p>Calon siswa dalam proses pendaftaran.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5><?= $totalTagihan ?> Tagihan</h5>
                            <p>Total tagihan yang tercatat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Diagram Status Tagihan</h5>
                </div>
                <div class="card-body text-center">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <canvas id="pieChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Chart.js
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_END]);

// Pie Chart Script
$this->registerJs(<<<JS
const ctx = document.getElementById('pieChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Lunas', 'Belum Lunas'],
        datasets: [{
            data: [$jumlahLunas, $jumlahBelum],
            backgroundColor: ['#28a745', '#dc3545'],
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#000'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let total = context.chart._metasets[context.datasetIndex].total;
                        let value = context.parsed;
                        let percentage = (value / total * 100).toFixed(1);
                        return context.label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
JS);
?>