<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<style>
.footer {
	margin-bottom: 22px;
}
.panel-primary .form-group {
	margin-bottom: 10px;
}
.form-control {
	border-radius: 0px;
	box-shadow: none;
}
.error_validasi { margin-top: 0px; }
</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}
?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-3'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">No. Nota</label>
									<div class="col-sm-8">
										<input type='text' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo strtoupper(uniqid()).$this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">`
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" <?php echo $disabled; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Kasir</label>
									<div class="col-sm-8">
										<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $disabled; ?>>
											<?php
											if($kasirnya->num_rows() > 0)
											{
												foreach($kasirnya->result() as $k)
												{
													$selected = '';
													if($k->id_user == $this->session->userdata('ap_id_user')){
														$selected = 'selected';
													}

													echo "<option value='".$k->id_user."' ".$selected.">".$k->nama."</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Informasi Pelanggan</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Pelanggan</label>
								<a href="<?php echo site_url('service/tambah-pelanggan'); ?>" class='pull-right' id='TambahPelanggan'>Tambah Baru ?</a>
								<select name='id_pelanggan' id='id_pelanggan' class='form-control input-sm' style='cursor: pointer;'>
									<option value=''>-- Umum --</option>
									<?php
									if($pelanggan->num_rows() > 0)
									{
										foreach($pelanggan->result() as $p)
										{
											echo "<option value='".$p->id_pelanggan."'>".$p->nama."</option>";
										}
									}
									?>
								</select>
							</div>

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">Telp / HP</label>
									<div class="col-sm-8">
										<div id='telp_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Alamat</label>
									<div class="col-sm-8">
										<div id='alamat_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Info Lain</label>
									<div class="col-sm-8">
										<div id='info_tambahan_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class='col-sm-9'>
					<h5 class='judul-service'>
						<i class='fa fa-shopping-cart fa-fw'></i> Service <i class='fa fa-angle-right fa-fw'></i> Terima Service
						<a href="<?php echo site_url('service/service'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					<table class='table table-bordered' id='Tabelservice'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:120px'>Nama Barang</th>
								<th style='width:120px;'>Serial Number</th>
								<th style='width:160px;'>Kelengkapan</th>
								<th style='width:100px;'>Kerusakan</th>
								<th style='width:60px;'>Penyelesaian</th>
								<th style='width:20px;'></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<div class='alert alert-info TotalBayar'>
						<button id='BarisBaru' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru (F7)</button>
						<h2>Total : <span id='TotalBayar'>Rp. 0</span></h2>
						<input type="hidden" id='TotalBayarHidden'>
					</div>

					<div class='row'>
						<div class='col-sm-7'>
							<textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan service (Jika Ada)" style='resize: vertical; width:83%;'></textarea>

							<br />
							<p><i class='fa fa-keyboard-o fa-fw'></i> <b>Shortcut Keyboard : </b></p>
							<div class='row'>
								<div class='col-sm-6'>F7 = Tambah baris baru</div>
								<div class='col-sm-6'>F9 = Cetak Struk</div>
								<div class='col-sm-6'>F8 = Fokus ke field bayar</div>
								<div class='col-sm-6'>F10 = Simpan service</div>
							</div>
						</div>
						<div class='col-sm-5'>
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-6 control-label">Bayar (F8)</label>
									<div class="col-sm-6">
										<input type='text' name='cash' id='UangCash' class='form-control' onkeypress='return check_int(event)'>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Kembali</label>
									<div class="col-sm-6">
										<input type='text' id='UangKembali' class='form-control' disabled>
									</div>
								</div>
								<div class='row'>
									<div class='col-sm-6' style='padding-right: 0px;'>
										<button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-print'></i> Cetak (F9)
										</button>
									</div>
									<div class='col-sm-6'>
										<button type='button' class='btn btn-primary btn-block' id='Simpann'>
											<i class='fa fa-floppy-o'></i> Simpan (F10)
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<br />
				</div>
			</div>

		</div>
	</div>
</div>



<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$(document).ready(function(){

	for(B=1; B<=1; B++){
		BarisBaru();
	}

	$('#id_pelanggan').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('service/ajax-pelanggan'); ?>",
				type: "POST",
				cache: false,
				data: "id_pelanggan="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#telp_pelanggan').html(json.telp);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info_tambahan);
				}
			});
		}
		else
		{
			$('#telp_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#info_tambahan_pelanggan').html('<small><i>Tidak ada</i></small>');
		}
	});

	$('#BarisBaru').click(function(){
		BarisBaru();
	});

	$("#Tabelservice tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
});

function BarisBaru()
{
	var Nomor = $('#Tabelservice tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Nama Barang'>";
			Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td>"
		  Baris += "<input type='text' class='form-control' name='serial_number[]' id='sn' placeholder='serial number'>";
			Baris += "<div id='sn'></div>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' name='Kelengkapan[]' id='Kelengkapan' placeholder='Kelengkapan'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='Kerusakan' name='Kerusakan[]' placeholder='Kerusakan''></td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' id='penyelesaian' name='penyelesaian[]' placeholder='penyelesaian'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#Tabelservice tbody').append(Baris);

	$('#Tabelservice tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});

	HitungTotalBayar();
}

$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#Tabelservice tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
});

function AutoCompleteGue(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 25;

	var Registered = '';
	$('#Tabelservice tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "<?php echo site_url('service/ajax-kode'); ?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(0);
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) span').html('');
			}
		}
	});

	HitungTotalBayar();
}

//
$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

	var Indexnya = $(this).parent().parent().parent().parent().index();
	var NamaBarang = $(this).find('span#barangnya').html();
	var Harganya = $(this).find('span#harganya').html();

	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(Harganya);
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
	$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(Harganya));

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#Tabelservice tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#jumlah_beli', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var JumlahBeli = $(this).val();
	var KodeBarang = $('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok'); ?>",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok="+JumlahBeli,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#Tabelservice tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('1');
			}
		}
	});
});

$(document).on('keydown', '#jumlah_beli', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#Tabelservice tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#UangCash', function(){
	HitungTotalKembalian();
});

function HitungTotalBayar()
{
	var Total = 0;
	$('#Tabelservice tbody tr').each(function(){
		if($(this).find('td:nth-child(6) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(6) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});

	$('#TotalBayar').html(to_rupiah(Total));
	$('#TotalBayarHidden').val(Total);

	$('#UangCash').val('');
	$('#UangKembali').val('');
}

function HitungTotalKembalian()
{
	var Cash = $('#UangCash').val();
	var TotalBayar = $('#TotalBayarHidden').val();

	if(parseInt(Cash) >= parseInt(TotalBayar)){
		var Selisih = parseInt(Cash) - parseInt(TotalBayar);
		$('#UangKembali').val(to_rupiah(Selisih));
	} else {
		$('#UangKembali').val('');
	}
}

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}

$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#UangCash').focus();
		return false;
	}

	if(charCode == 120) //F9
	{
		CetakStruk();
		return false;
	}

	if(charCode == 121) //F10
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan service ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='Simpanservice'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){
	   		$('button#Simpanservice').focus();
	    }, 500);

		return false;
	}
});

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan service ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='Simpanservice'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){
   		$('button#Simpanservice').focus();
    }, 500);
});

$(document).on('click', 'button#Simpanservice', function(){
	Simpanservice();
});

$(document).on('click', 'button#CetakStruk', function(){
	CetakStruk();
});

function Simpanservice()
{
	var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	FormData += "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&id_kasir="+$('#id_kasir').val();
	FormData += "&id_pelanggan="+$('#id_pelanggan').val();
	FormData += "&" + $('#Tabelservice tbody input').serialize();
	FormData += "&cash="+$('#UangCash').val();
	FormData += "&catatan="+encodeURI($('#catatan').val());
	FormData += "&grand_total="+$('#TotalBayarHidden').val();

	$.ajax({
		url: "<?php echo site_url('service/service'); ?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				alert(data.pesan);
				window.location.href="<?php echo site_url('service/service'); ?>";
			}
			else
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}
		}
	});
}

$(document).on('click', '#TambahPelanggan', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Pelanggan');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});

function CetakStruk()
{
	if($('#TotalBayarHidden').val() > 0)
	{
		if($('#UangCash').val() !== '')
		{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_pelanggan="+$('#id_pelanggan').val();
			FormData += "&" + $('#Tabelservice tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();

			window.open("<?php echo site_url('service/service-cetak/?'); ?>" + FormData,'_blank');
		}
		else
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap masukan Total Bayar');
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		}
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih barang terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}
</script>

<?php $this->load->view('include/footer'); ?>
