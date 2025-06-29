<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/template/css/pengajuan.css'); ?>" />
<div class="row">
    <div class="col-xl-12">
        <div class="container">
            <h2 class="text-center">Laporan Pengajuan</h2>
            
            <div class="filter-section">
                <h5>Filter Laporan</h5>
                <div class="card" style="padding: 20px;">
                    <form method="get" class="row">
                        <div class="row">
                            <div class="col-5">
                                <label for="start_date" class="form-label">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
                            </div>
                            <div class="col-5">
                                <label for="end_date" class="form-label">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
                            </div>
                            
                            <div class="col-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br><br>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="table-datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>No Surat</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)) : ?>
                            <tr>
                                <td colspan="6" class="text-muted">Silakan pilih rentang tanggal terlebih dahulu atau data tidak ditemukan.</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($riwayat as $row) : ?>
                                <tr>
                                    <td><?= str_pad($no++, 2, '0', STR_PAD_LEFT); ?></td>
                                    <td><?= htmlspecialchars($row->no_surat); ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->tanggal_pengajuan)); ?></td>
                                    <td><?= htmlspecialchars($row->perihal); ?></td>
                                    <td>
                                        <?php
                                            // $status = strtolower($row->status_pengajuan);
                                            // $warna = match ($status) {
                                            //     'diproses' => 'info',
                                            //     'dikirim' => 'primary',
                                            //     'direvisi' => 'warning',
                                            //     'diterima' => 'success',
                                            //     'ditolak' => 'danger',
                                            //     default => 'secondary'
                                            // };
                                        ?>
                                        <span class="badge bg-<?= $warna; ?> text-capitalize"><?= htmlspecialchars($row->status_pengajuan); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('user/detail_pengajuan/' . $row->id_pengajuan); ?>" 
                                        class="btn btn-sm btn-outline-info">Lihat Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript (tanpa data dummy) -->
<script>
    function formatBadge(status) {
        switch (status) {
            case 'dikirim': return '<span class="badge-dikirim">Dikirim</span>';
            case 'direvisi': return '<span class="badge-direvisi">Direvisi</span>';
            case 'diterima': return '<span class="badge-diterima">Diterima</span>';
            case 'ditolak': return '<span class="badge-ditolak">Ditolak</span>';
            default: return '';
        }
    }

    function filterData(event) {
        event.preventDefault();

        // Ambil tanggal filter
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        const tbody = document.getElementById('reportBody');
        const reportCard = document.getElementById('reportCard');
        const noDataMessage = document.getElementById('noDataMessage');

        // Di sini kamu bisa ganti dengan request ke backend
        // Contoh: fetch('laporan.php?from='+fromDate+'&to='+toDate)

        // Untuk sekarang: kosongin table
        tbody.innerHTML = '';
        reportCard.style.display = 'none';
        noDataMessage.style.display = 'block';
    }
</script>

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengajuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .filter-section {
            margin-bottom: 20px;
        }
        .data-table {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
        }
        .status-dikirim { background-color: #17a2b8; color: white; }
        .status-direvisi { background-color: #ffc107; color: black; }
        .status-diterima { background-color: #28a745; color: white; }
        .status-ditolak { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Laporan Pengajuan</h2>
    
    <div class="filter-section">
        <h5>Filter Laporan</h5>
        <div class="row">
            <div class="col">
                <label>Dari Tanggal</label>
                <input type="date" class="form-control" id="start-date">
            </div>
            <div class="col">
                <label>Sampai Tanggal</label>
                <input type="date" class="form-control" id="end-date">
            </div>
            <div class="col">
                <button class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
    </div>

    <div class="data-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Perihal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>980</td>
                    <td>06/02/2025</td>
                    <td>Pengajuan Seminar AI</td>
                    <td class="status-dikirim">Dikirim</td>
                    <td><button class="btn btn-info">Lihat Detail</button></td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>981</td>
                    <td>06/02/2025</td>
                    <td>Pengajuan Seminar Data</td>
                    <td class="status-direvisi">Direvisi</td>
                    <td><button class="btn btn-info">Lihat Detail</button></td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>982</td>
                    <td>06/03/2025</td>
                    <td>Permohonan Izin Penelitian</td>
                    <td class="status-diterima">Diterima</td>
                    <td><button class="btn btn-info">Lihat Detail</button></td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>983</td>
                    <td>06/04/2025</td>
                    <td>Pengajuan Seminar</td>
                    <td class="status-ditolak">Ditolak</td>
                    <td><button class="btn btn-info">Lihat Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <p>Showing 1 to 4 of 4 entries</p>
        <button class="btn btn-secondary">Kembali</button>
        <span>|</span>
        <button class="btn btn-secondary">1</button>
        <span>|</span>
        <button class="btn btn-secondary">next</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> -->
