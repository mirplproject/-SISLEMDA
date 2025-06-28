<div class="row">
    <div class="col-xl-12">
        <h2 class="mb-4">Riwayat Lembar Pengajuan</h2>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Pengajuan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="riwayatTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username Pengaju</th>
                                <th>No Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status Pengajuan</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($riwayat_data)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($riwayat_data as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
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
                                                    case 'tidak tersedia':
                                                        $status_color = 'secondary';
                                                        break;
                                                    default:
                                                        break;
                                                }
                                            ?>
                                            <h5><span class="badge rounded-pill text-bg-<?php echo $status_color; ?>"><?php echo htmlspecialchars($row['status_pengajuan']); ?></span></h5>
                                        </td>
                                        <td><a href="<?php echo site_url('user/detail_pengajuan/' . $row['id_pengajuan']) ?>" class="btn btn-primary btn-sm">DETAIL</a></td>
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
        </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
<script type="text/javascript" src="<?php echo base_url('assets/template/js/jquery-3.7.1.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

<script>
    // Pastikan DOM sudah siap sebelum menginisialisasi DataTable
    $(document).ready(function() {
        let table = new DataTable('#riwayatTable', {
            perPage: 10,
            perPageSelect: [10, 25, 50, 100],
            searchable: true,
            sortable: true,
            labels: {
                placeholder: "Cari...",
                perPage: "{select} baris per halaman",
                noRows: "Tidak ada data yang ditemukan",
                info: "Menampilkan {start} sampai {end} dari {rows} baris"
            }
        });
    });
</script>