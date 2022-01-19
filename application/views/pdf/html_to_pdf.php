<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		.tbl_data {
		  width: 100%;
		  border-collapse: collapse;
		  border: 1px solid black;
		}
		.tbl_data td {
		  border: 1px solid black;
		}
		.row_header_data td {
		  text-align: center;
		}
</style>
</head>
<body style="font-size:10px;font-family: Arial, Helvetica, sans-serif;padding:50px">
	<table border="0" style="width: 100%;">
		<tr>
			<td><img src="<?php echo base_url() ?>assets/images/logo-alto.png" height="50" width="70" alt="ATMI"></td>
		</tr>
	</table>
	<table border="0" style="width: 100%;">
		<tr>
			<td width="550">PT Alto Network</td>
			<td style="text-align: right;">Tanggal : <?=date("d M Y")?></td>
		</tr>
		<tr>
			<td>Satrio Tower Office Building Lt. 12</td>
		</tr>
		<tr>
			<td>Jl. Prof. DR. Satrio,Jakarta Selatan 12950</td>
		</tr>
		
	</table>
	<br>
	<table>
		<tr><td></td></tr>
		<tr>
			<td>Kepada</td>
			<td>:</td>
			<td>ATMI</td>
		</tr>
		<tr>
			<td>Up</td>
			<td>:</td>
			<td>PT. Abadi Tambah Mulia International</td>
		</tr>
		<tr>
			<td>Fax No</td>
			<td>:</td>
			<td>2953-3277</td>
		</tr>
	</table>
<br>
	<table>
		<tr><td>Dengan ini kami kirimkan Laporan Settlement Fee Acquire dari PT. Alto Network</td></tr>
		<tr>
			<td>Mohon debet rekening kami A/C No. 228-80-00382 dan kredit rekening-rekening di bawah ini :</td>
		</tr>
	</table>
<br>
	<table class="tbl_data" >
		<tr class="row_header_data">
			<td>No</td>
			<td>No. Rekening</td>
			<td>Pemilik Rekening</td>
			<td>Jumlah</td>
			<td>Keterangan</td>
		</tr>
		<tr>
			<td style="text-align: center;width:20px">1</td>
			<td style="text-align: center;width:150px">BII KCP PURI KENCANA 2288004002</td>
			<td style="padding-left: 5px;">Pt Abadi Tambah Mulia Internasional</td>
			<td style="text-align: right; padding-right: 5px;"><?= $amount ?></td>
			<td style="padding-left: 5px;">Settlement FEE_Acquire_ATMi</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td style="padding-left: 5px;">Total</td>
			<td style="text-align: right; padding-right: 5px;"><?= $amount ?></td>
			<td></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Terbilang : (<?= $terbilang ?> Rupiah# )</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td>Hormat Kami</td>
		</tr>
	</table>
	<br>
	<img src="<?php echo base_url() ?>assets/images/sign/sign_off_settlement.png" height="50" width="90" >
	<br>
	<table>
		<tr>
			<td><?= $sign_by ?></td>
		</tr>
	</table>
</body>
</html>