<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Kendali Disposisi - <?php echo htmlspecialchars($nama_penerima_disposisi ?? 'N/A'); ?></title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif; /* Fallback font, penting untuk Dompdf */
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 20mm 15mm; /* Margin atas/bawah 2cm, kiri/kanan 1.5cm */
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1, .header h2, .header h3 {
            margin: 0;
            padding: 0;
        }
        .header img {
            max-width: 80px; /* Sesuaikan ukuran logo */
            float: left;
            margin-right: 15px;
        }
        .clear::after {
            content: "";
            clear: both;
            display: table;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-size: 11pt;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .info-item strong {
            display: inline-block;
            width: 150px; /* Lebar label */
            vertical-align: top;
        }
        .info-item span {
            display: inline-block;
            vertical-align: top;
            width: calc(100% - 160px); /* Sisa lebar */
        }
        .badge {
            display: inline-block;
            padding: .3em .6em;
            font-size: 85%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            color: #fff; /* Default text color */
        }
        .bg-success { background-color: #28a745 !important; }
        .bg-danger { background-color: #dc3545 !important; }
        .bg-warning { background-color: #ffc107 !important; color: #333 !important; }
        .bg-secondary { background-color: #6c757d !important; }
        .text-muted { color: #6c757d; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 9pt;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header clear">
            <img src="<?php echo base_url('assets/template/img/logo_binainsani.png'); ?>" alt="Logo Perusahaan" style="width:80px; height:auto;">
            <div>
                <h3>UNIVERSITAS BINA INSANI</h3>
                <p style="font-size: 9pt; margin-top: 5px;">
                    Jl. Raya Jakarta-Bogor Km. 50 No. 27, Nanggewer Mekar, Kec. Cibinong, Kab. Bogor, Jawa Barat 16912 <br>
                    Telp: (021) 87981234 | Email: info@binainsani.ac.id | Website: www.binainsani.ac.id
                </p>
            </div>
        </div>

        <h2 style="text-align: center; margin-bottom: 25px; font-size: 14pt;">LEMBAR KENDALI DISPOSISI</h2>

        <div style="margin-bottom: 20px;">
            <div class="info-item">
                <strong>No. Pengajuan:</strong>
                <span><?= htmlspecialchars($row->no_surat ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Nama Pengaju:</strong>
                <span><?= htmlspecialchars($row->nama_user ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Tanggal Pengajuan:</strong>
                <span><?= isset($row->tanggal_pengajuan) ? date('d F Y', strtotime($row->tanggal_pengajuan)) : '-' ?></span>
            </div>
            <div class="info-item">
                <strong>Klasifikasi Surat:</strong>
                <span><?= htmlspecialchars($row->nama_surat ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Perihal:</strong>
                <span><?= htmlspecialchars($row->perihal ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Status Pengajuan:</strong>
                <span>
                    <?php
                        $status_color = '';
                        switch ($row->status_pengajuan) {
                            case 'disetujui': $status_color = 'success'; break;
                            case 'ditolak': $status_color = 'danger'; break;
                            case 'kadaluarsa': $status_color = 'warning'; break;
                            case 'direvisi': $status_color = 'warning'; break; // Revisi sebagai warning juga di laporan
                            case 'diproses': $status_color = 'secondary'; break;
                            default: $status_color = 'secondary'; break;
                        }
                    ?>
                    <span class="badge bg-<?= $status_color ?>">
                        <?= ucfirst(htmlspecialchars($row->status_pengajuan ?? 'Belum diproses')) ?>
                    </span>
                </span>
            </div>
        </div>

        <div class="section-title">Lampiran</div>
        <?php if (!empty($row->lampiran)): ?>
            <ul style="list-style-type: none; padding-left: 0;">
                <?php foreach ($row->lampiran as $lampiran): ?>
                    <li style="margin-bottom: 5px;">
                        <a href="<?= base_url('uploads/' . $lampiran->file) ?>" target="_blank" style="color: #007bff; text-decoration: none;">
                            &#128206; <?= htmlspecialchars($lampiran->file) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Tidak ada lampiran tersedia.</p>
        <?php endif; ?>

        <div class="section-title">Riwayat Disposisi</div>
        <?php if (!empty($riwayat_disposisi)): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">Kepada YTH</th>
                        <th style="width: 15%;">N/K</th>
                        <th style="width: 20%;">Tanggal Disposisi</th>
                        <th style="width: 40%;">Catatan Disposisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat_disposisi as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d->dari_nama ?? '-') ?></td>
                            <td><?= htmlspecialchars($d->dari_nik ?? '-') ?></td>
                            <td><?= date('d F Y', strtotime($d->tanggal_disposisi)) ?></td>
                            <td><?= htmlspecialchars($d->catatan) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">Tidak ada data disposisi.</p>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <div class="info-item">
                <strong>No. Lembar Kendali:</strong>
                <span><?= htmlspecialchars($lembar_kendali_config['no_lembar_kendali'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Kode Dokumen Internal:</strong>
                <span><?= htmlspecialchars($lembar_kendali_config['kode_dokumen_internal'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Jumlah Revisi:</strong>
                <span><?= htmlspecialchars($jumlah_revisi ?? '0') ?> kali</span>
            </div>
            <div class="info-item">
                <strong>Ditutup Tanggal:</strong>
                <span><?= htmlspecialchars($lembar_kendali_config['ditutup_tgl'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Disimpan Tanggal:</strong>
                <span><?= htmlspecialchars($lembar_kendali_config['disimpan_tgl'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <strong>Unit Kerja Penyimpanan:</strong>
                <span><?= htmlspecialchars($lembar_kendali_config['unit_kerja_penyimpanan'] ?? '-') ?></span>
            </div>
        </div>

        <div class="footer">
            Generated on <?= date('d F Y H:i:s') ?> by SISLEMDA
        </div>
    </div>
</body>
</html>