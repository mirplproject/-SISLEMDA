<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SISLEMDA - Pilih Role</title>
    <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #e8f5e9;
            color: #1b5e20;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .role-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .btn-primary {
            background-color: #00923F;
            border-color: #00923F;
        }
        .btn-primary:hover {
            background-color: #1b5e20;
            border-color: #1b5e20;
        }
    </style>
</head>
<body>
    <div class="role-container">
        <h2 class="text-center mb-4">Pilih Role</h2>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo site_url('auth/choose_role'); ?>">
            <div class="form-group mb-3">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="">Pilih Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role['nama_role']; ?>"><?php echo ucfirst($role['nama_role']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Pilih Role</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>