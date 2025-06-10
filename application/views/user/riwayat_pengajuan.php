<div class="row ">
    <div class="col-xl-12">
        <h2 class="mb-4">Riwayat Lembar Pengajuan</h2>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="riwayatTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username Pengaju</th>
                        <th>Klasifikasi Surat</th>
                        <th>No Surat</th>
                        <th>Perihal</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status Pengajuan</th>
                        </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat_data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($riwayat_data as $row): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_surat']); ?></td>
                                <td><?php echo htmlspecialchars($row['no_surat']); ?></td>
                                <td><?php echo htmlspecialchars($row['perihal']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                                <td>
                                    <?php
                                        $status_color = '';
                                        switch ($row['status_pengajuan']) {
                                            case 'disetujui':
                                                $status_color = 'success';
                                                break;
                                            case 'ditolak':
                                                $status_color = 'danger';
                                                break;
                                            case 'kadaluarsa':
                                                $status_color = 'warning';
                                                break;
                                            default:
                                                $status_color = 'secondary';
                                                break;
                                        }
                                    ?>
                                    <span class="badge badge-<?php echo $status_color; ?>"><?php echo htmlspecialchars($row['status_pengajuan']); ?></span>
                                </td>
                                </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data riwayat pengajuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#riwayatTable').DataTable({
            // Konfigurasi DataTables default (client-side processing)
            // Cukup ini saja jika tidak ada server-side processing
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    });
</script>