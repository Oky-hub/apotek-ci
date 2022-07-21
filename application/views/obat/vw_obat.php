<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="clearfix">
			<div class="float-left">
				<h1 class="page-header"><?php echo $judul; ?></h1>
			</div>
			<div class="col-md-4 col-md-offset-10">
				<h1 class="h3 mb-4 text-gray 800">
					<a href="<?= base_url(); ?>Obat/tambah" class="btn btn-outline btn-info btn-sm">Tambah Obat</a>
				</h1>
			</div>
		</div>
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<td>No</td>
								<td>Nama</td>
								<td>Harga</td>
								<td>Stok</td>
								<td>Gambar</td>
								<td>Aksi</td>
							</tr>
						</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($obat as $us) : ?>
									<tr>
										<td> <?= $i; ?>.</td>
										<td><?= $us['nama']; ?></td>
										<td><?= $us['harga']; ?></td>
										<td><?= $us['stok']; ?></td>
										<td><img src="<?= base_url('/assets/img/obat/') . $us['gambar']; ?>" style="width:100px" 
										class="img-thumbnail"></td>
										<td>
											<a href="<?= base_url('Obat/hapus/') . $us['id']; ?>" class="badge badge-danger">Hapus</a>
											<a href="<?= base_url('Obat/edit/') . $us['id']; ?>" class="badge badge-warning">Edit</a>
										</td>
									</tr>
									<?php $i++; ?>
									<?php endforeach; ?>
							</tbody>
					</table>
				</div>
			</div>
         </div>
	</div>
</div>