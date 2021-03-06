<?php
require_once "../../models/abspath.php";
require_once "sessions.php";
require_once "pdocon.php";
require_once "function.php";
require_once "toxls.php";

$q = "SELECT *,CONCAT('$KdPengguna-$NoReg1','-',DATE_FORMAT(TgDaf,'%Y%m%d'),'-',CAR) AS FCAR,CONCAT(LEFT(NoDaf,3),'.',RIGHT(NoDaf,3)) AS FNoDaf,DATE_FORMAT(TgDaf,'%d-%b-%y') AS tgl_daf FROM header h WHERE DokKdBc='1' AND CAR='".$_REQUEST['CAR']."' LIMIT 1";
$rec = $pdo->query($q);
$rs = $rec->fetchAll(PDO::FETCH_ASSOC);

$qCust="SELECT * FROM tbcustomer WHERE Number='".$rs[0]['KdTujKirim']."' LIMIT 1";
$recCust = $pdovb->query($qCust);
$rsCust = $recCust->fetchAll(PDO::FETCH_ASSOC);

$qBarang="SELECT * FROM barang WHERE DokKdBc='1' AND CAR='".$_REQUEST['CAR']."' ORDER BY no";
$recBarang = $pdo->query($qBarang);
$rsBarang = $recBarang->fetchAll(PDO::FETCH_ASSOC);
$countBarang=count($rsBarang);

$qSumBarang="SELECT SUM(qty) as totQty,SUM(CIF) as totCIF,SUM(HrgSerah) as totHrgSerah FROM barang WHERE DokKdBc='1' AND CAR='".$_REQUEST['CAR']."'";
$recSumBarang = $pdo->query($qSumBarang);
$rsSumBarang = $recSumBarang->fetchAll(PDO::FETCH_ASSOC);
$totQty=$rsSumBarang[0]['totQty'];
$totCIF=$rsSumBarang[0]['totCIF'];
$totHrgSerah=$rsSumBarang[0]['totHrgSerah'];


$qDokPelengkap="SELECT *,DATE_FORMAT(DokTg,'%d-%b-%y') AS FDokTg FROM dokumen WHERE DokKdBc='1' AND CAR='".$_REQUEST['CAR']."' ORDER BY no";
$recDokPelengkap = $pdo->query($qDokPelengkap);
$rsDokPelengkap = $recDokPelengkap->fetchAll(PDO::FETCH_ASSOC);
$countDokPelengkap=count($rsDokPelengkap);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta name="Author" content="Kikin Kusumah" />
<style type="text/css" media="all">	
#borderAll {
    border: 1px solid #000;	  	    
}
.p_spacing{
    margin-top:4px;
    margin-bottom:4px;
}
table.tablereport {
    page-break-after:always;
    border: 1px solid #000;	
    border-collapse:collapse;
    margin:5px 0pt 10px;		
    font-size: 9pt;
    width: 8.27in;	
    /*height:11.69in;*/
    height:10.90in;
}
table.tablereport thead tr td{		
    border: 1px solid #000;		
    font-size: 9pt;		
    padding: 4px;
    vertical-align:top;
}	
table.tablereport tbody tr td {
    border: 1px solid #000;		
    font-size: 9pt;		
    padding: 4px;
    vertical-align:top;
}
table.tablereport tfoot tr td {
    border: 1px solid #000;		
    font-size: 9pt;		
    padding: 4px;
    vertical-align:top;
}
.borderall{
    border:1px #000 solid !important;
}
.noborder{
    border:1px #FFF solid !important;
}
.noborderlrb{
    border-left:hidden !important;
    border-right:hidden !important;
    border-bottom:hidden !important;
}
.nobordertr{
    border-top:hidden !important;
    border-right:hidden !important;
}
.nobordert{
    border-top:hidden !important;	
}
.noborderright{
    border-right:hidden !important;
}
.noborderbtm{
    border-bottom:hidden !important;
}
.noborderrb{
    border-right:hidden !important;
    border-bottom:hidden !important;
}	
</style>
<body>
<table cellpadding="1" cellspacing="0" class="tablereport">
<tbody>
<tr>
  <td colspan="17"><h2>PEMBERITAHUAN IMPOR BARANG UNTUK DITIMBUN DI<br>TEMPAT PENIMBUNAN BERIKAT</h2></td>
</tr>
<tr>
  <td align="center" colspan="2" valign="middle"><h2>BC 2.3 </h2></td>
  <td class="noborderright">&nbsp;</td>
  <td align="center" colspan="14"><h3>PEMBERITAHUAN PEMASUKAN BARANG ASAL TEMPAT LAIN DALAM<br>DAERAH PABEAN KE TEMPAT PENIMBUNAN BERIKAT</h3></td>
</tr>
<tr>
  <td colspan="17"><b>HEADER</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="4">NOMOR PENGAJUAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderrb" colspan="3"><?php echo $rs[0]['FCAR'] ?></td>
  <td align="right" colspan="9">Halaman 1 Dari ...
    <?php //if($countBarang > 1 && $countDokPelengkap > 0){echo "3";}else if($countBarang > 1 || $countDokPelengkap > 0){echo "2";} else { echo "1";} ?>
  &nbsp; &nbsp; </td>
</tr>
<tr>
  <td class="noborderrb" colspan="4">A. KANTOR PABEAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="3"><?php echo getKantor($rs[0]['KdKpbcAsal']) ?></td>
  <td class="noborderbtm" colspan="9"><b>F. KOLOM KHUSUS BEA DAN CUKAI</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="4">B. JENIS TPB</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="3"><?php echo getJnsTpb($rs[0]['KdJnsTpbAsal']) ?></td>
  <td class="noborderrb" colspan="2">Nomor Pendaftaran</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['FNoDaf'] ?>&nbsp;</span></td>
</tr> 
<tr>
  <td class="noborderrb" colspan="4">C. TUJUAN PENGIRIMAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="3"><?php echo getTujKirim($rs[0]['KdTp']) ?></td>
  <td class="noborderright" colspan="2">Tanggal</td>
  <td class="noborderright">:</td>
  <td colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['tgl_daf'] ?>&nbsp;</span></td>
</tr> 
<tr>
	<td class="nobordertr" width="30"></td>
    <td class="nobordertr" width="62"></td>
    <td class="nobordertr" width="11"></td>
    <td class="nobordertr" width="33"></td>
    <td class="nobordertr" width="11"></td>
    <td width="85" class="nobordertr"></td>
    <td class="nobordertr" width="60"></td>
    
    <td class="nobordert" width="50"></td>    
    <td class="nobordertr" width="50"></td>    
    <td class="nobordertr" width="68"></td>
    <td class="nobordertr" width="11"></td>
    <td width="77" class="nobordertr"></td>
    <td class="nobordertr" width="40"></td>
    <td class="nobordertr" width="70"></td>
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr" width="30"></td>
    <td class="nobordert" width="20"></td>
</tr>
<tr>
  <td colspan="17"><b>D. DATA PEMBERITAHUAN</b></td>
</tr>
<tr>
  <td colspan="8">PENGUSAHA TPB</td>  
  <td colspan="9">PENGIRIM BARANG</td>
</tr>
<tr>
  <td class="noborderrb" colspan="2">1. NPWP</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="5"><?php echo $_SESSION['npwp'] ?></td>
  <td class="noborderrb" colspan="2">5. NPWP</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><?php echo $rs[0]['NpwpTuj'] ?></td>
</tr> 
<tr>
  <td class="noborderrb" colspan="2">2. NAMA</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="5"><?php echo $_SESSION['c_name'] ?></td>
  <td class="noborderrb" colspan="2">6. NAMA</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><?php echo $rs[0]['NmTuj'] ?></td>
</tr> 
<tr>
  <td class="noborderrb" colspan="2" valign="top">3. ALAMAT</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="5"><?php echo $_SESSION['c_address'] ?></td>
  <td class="noborderrb" colspan="2">7. ALAMAT</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><?php echo $rs[0]['AlamatTuj'] ?></td>
</tr>
<tr>
  <td class="noborderright" colspan="2" valign="top">4. NO IZIN TPB</td>
  <td class="noborderright">:</td>
  <td colspan="5"><?php echo $_SESSION['NoIjinTpb'] ?></td>
  <td colspan="9">&nbsp;</td>
</tr> 
<tr>
  <td colspan="17"><b>DOKUMEN PELENGKAP PABEAN</b></td>  
</tr>
<tr>
  <td class="noborderrb" colspan="2">8. Packing List</td>
  <td class="noborderrb">:</td>
  <td class="noborderrb" colspan="3"><?php echo getDokPelengkap(8,$rs[0]['CAR'],2,1) ?></td>
  <td class="noborderbtm" colspan="2">Tgl. <?php echo getDokPelengkap(8,$rs[0]['CAR'],2,2) ?></td>
  <td class="noborderbtm" colspan="9">10. Surat Keputusan/Persetujuan : <?php echo getDokPelengkap(8,$rs[0]['CAR'],5,1) ?></td>
</tr>
<tr>
  <td class="noborderright" colspan="2" rowspan="3">9. Kontrak</td>
  <td class="noborderright" rowspan="3">:</td>
   <td class="noborderright" colspan="3" rowspan="3"><?php echo getDokPelengkapAll(8,$rs[0]['CAR'],3,1) ?></td>
  <td colspan="2" rowspan="3"><?php echo getDokPelengkapAll(8,$rs[0]['CAR'],3,2) ?></td>
  <td class="noborderbtm" colspan="9"> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tgl. <?php echo getDokPelengkap(8,$rs[0]['CAR'],5,2) ?></td>
</tr> 
<tr>
  <?php /*<td class="noborderbtm" colspan="8">&nbsp;</td>*/?>
  <td class="noborderbtm" colspan="9">11. Jenis/Nomor/Tanggal dokumen lainnya : <?php echo getDokPelengkap(8,$rs[0]['CAR'],6,1) ?></td>
</tr>
<tr>
  <?php /*<td colspan="8">&nbsp;</td>*/?>
  <td colspan="9"> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tgl. <?php echo getDokPelengkap(8,$rs[0]['CAR'],6,2) ?></td>
</tr>
<tr>
  <td colspan="17"><b>DATA PENGANGKUTAN</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="8">12. Jenis Sarana Pengangkut Darat : <span class="noborderright"><?php echo $rs[0]['JnsAngkut'] ?></span></td>
  <td class="noborderbtm" colspan="9">13. No. Polisi : <?php echo $rs[0]['NoPolisi'] ?></td>
</tr>
<tr>
  <td colspan="17"><b>DATA PERDAGANGAN</b></td>
</tr>
<tr>
  <td class="noborderright" colspan="4">14. Harga Penyerahan</td>
  <td class="noborderright">:</td>
  <td colspan="12"><?php echo $rs[0]['KdVal'] ?> <?php echo number_format($rs[0]['HrgSerah']) ?></td>
</tr>
<tr>
  <td colspan="17"><b>DATA PENGEMAS</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="4">15. Jenis Kemasan</td>
  <td class="noborderrb">:</td>
  <td class="noborderrb" colspan="3"><?php echo getKemasan($rs[0]['KdKemas']) ?></td>
  <td class="noborderbtm" colspan="9">17. Jumlah Kemasan : <?php echo number_format($rs[0]['JmlKemas']) ?></td>
</tr>
<tr>
  <td class="noborderright" colspan="4">16. Merek Kemasan</td>
  <td class="noborderright">:</td>
  <td colspan="12"><?php echo $rs[0]['MerekKemas'] ?></td>
</tr>
<tr>
  <td colspan="17"><b>DATA BARANG</b></td>
</tr>
<tr>
  <td class="noborderright" colspan="5">20. Volume (m3) : <?php echo number_format($rs[0]['VOL']) ?></td>
  <td class="noborderright" colspan="3">21. Berat Kotor (kg) : <?php echo number_format($rs[0]['BRUTO']) ?></td>
  <td colspan="9">22. Berat Bersih (kg) : <?php echo number_format($rs[0]['NETTO']) ?></td>
</tr>
<tr>
  <td class="noborderbtm" width="30">21.</td>
  <td class="noborderrb">22.</td>
  <td class="noborderbtm" colspan="7">&nbsp;</td>
  <td class="noborderbtm" colspan="4">23.</td>
  <td class="noborderbtm" colspan="4">24.</td>
</tr>
<tr>
  <td>No. </td>
  <td colspan="8">  Pos Tarif HS, Uraian Jumlah dan Jenis Barang secara Lengkap,<br>Kode Barang, Merk, Tipe, Ukuran, dan Spesifikasi Lain</td>
  <td colspan="4">- Jumlah & Jenis Satuan<br>- Berat bersih (Kg)<br> - Volume (m3)</td>
  <td colspan="4">- Nilai CIF <br>- Harga Penyerahan </td>
</tr>
<?php
if ($countBarang<4){
$str = "";
for ($i=0;$i<$countBarang;$i++):
?>
<tr>
  <td align="center" class="noborderbtm"><?php echo $rsBarang[$i]['no'] ?></td>
  <td class="noborderbtm" colspan="8"><?php echo $rsBarang[$i]['UrBarang']."<br>".$rsBarang[$i]['KdBarang'] ?></td>
  <td align="right" class="noborderbtm" colspan="4"><?php echo $rsBarang[$i]['qty']." ".$rsBarang[0]['unit'] ?> &nbsp; &nbsp; &nbsp; </td>
  <td class="noborderrb">&nbsp;</td>
  <td class="noborderrb"><?php echo $rs[0]['KdVal'] ?></td>
  <td align="right" class="noborderrb"><?php echo number_format($rsBarang[$i]['HrgSerah'],2);?></td>
  <td align="right" class="noborderbtm">&nbsp;</td>
</tr>
<?php 
endfor; 
} else {
?>
<tr>
  <td> </td>
  <td align="center" colspan="16"><b>" LIHAT LEMBAR LANJUTAN "</b></td>
</tr> 
<?php
}
?>
<tr height="100%">
  <td></td>
  <td align="right" colspan="8" style="vertical-align:bottom">TOTAL =></td>
  <td align="right" colspan="4" style="vertical-align:bottom"><?php echo $totQty." ".$rsBarang[0]['unit'] ?> &nbsp; &nbsp; &nbsp; </td>
  <td class="noborderright">&nbsp;</td>
  <td class="noborderright" style="vertical-align:bottom"><?php echo $rs[0]['KdVal'] ?></td>
  <td align="right" class="noborderright" style="vertical-align:bottom"><?php echo number_format($totHrgSerah,2) ?></td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="8"><b>G. UNTUK PEJABAT BEA DAN CUKAI</b></td>
  <td colspan="9"><b>E. TANDA TANGAN PENGUSAHA TPB</b></td>
</tr>
<tr>
  <td align="center" colspan="8">&nbsp;<br><br><br><br><br>
    <?php echo $rs[0]['NmPejabat'] ?><br>NIP. <?php echo $rs[0]['NipPejabat'] ?></td>
  <td colspan="9">
  Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal<br>
  yang diberitahukan dalam pemberitahuan pabean ini.<br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; Subang, <?php echo $rs[0]['tgl_daf'] ?><br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $rs[0]['NmPengusaha'] ?></td>
</tr> 
<tr>
  <td class="noborderlrb" colspan="17">Rangkap ke- 1/2/3 : Kantor Pabean / Pengusaha TPB / Pengirim Barang  </td>
</tr>
</tbody>
</table>
<?php if($countBarang>3): ?>
<table cellpadding="1" cellspacing="0" class="tablereport">
<tbody>
<tr>
  <td align="center" colspan="2"><h2>BC 4.0 </h2></td>
  <td class="noborderright">&nbsp;</td>
  <td align="center" colspan="14"><h3>LEMBAR LANJUTAN<br>DATA BARANG</h3></td>
</tr>
<tr>
  <td colspan="17"><b>HEADER</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">NOMOR PENGAJUAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderrb" colspan="4"><?php echo $rs[0]['FCAR'] ?></td>
  <td align="right" colspan="9">Halaman 2 Dari ... 
    <?php //if ($countDokPelengkap > 0){echo "2 Dari 3";}else{echo "2 Dari 2";}?>&nbsp; &nbsp; </td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">A. KANTOR PABEAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo $rs[0]['KdKpbcAsal'] ?></td>
  <td class="noborderbtm" colspan="9"><b>F. KOLOM KHUSUS BEA DAN CUKAI</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">B. JENIS TPB</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo getJnsTpb($rs[0]['KdJnsTpbAsal']) ?></td>
  <td class="noborderrb" colspan="2">Nomor Pendaftaran</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['FNoDaf'] ?>&nbsp;</span></td>
</tr> 
<tr>
  <td class="noborderrb" colspan="3">C. TUJUAN PENGIRIMAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo getTujKirim($rs[0]['KdTp']) ?></b></td>
  <td class="noborderright" colspan="2">Tanggal</td>
  <td class="noborderright">:</td>
  <td colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['tgl_daf'] ?>&nbsp;</span></td>
</tr> 
<tr>
	<td class="nobordertr" width="10"></td>
    <td class="nobordertr" width="80"></td>
    <td class="nobordertr" width="30"></td>
    <td class="nobordertr" width="5"></td>
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr"></td>
    <td class="nobordertr" width="60"></td>
    
    <td class="nobordert" width="50"></td>    
    <td class="nobordertr" width="50"></td>    
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr" width="5"></td>
    <td class="nobordertr"></td>
    <td class="nobordertr" width="40"></td>
    <td class="nobordertr" width="70"></td>
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr" width="30"></td>
    <td class="nobordert" width="20"></td>
</tr>
<tr>
  <td class="noborderbtm" width="30">21.</td>
  <td class="noborderrb">22.</td>
  <td class="noborderbtm" colspan="6">&nbsp;</td>
  <td class="noborderbtm" colspan="5">23.</td>
  <td class="noborderbtm" colspan="4">24.</td>
</tr>
<tr>
  <td>No. </td>
  <td colspan="7">  Pos Tarif HS, Uraian Jumlah dan Jenis Barang secara Lengkap,<br>Kode Barang, Merk, Tipe, Ukuran, dan Spesifikasi Lain</td>
  <td colspan="5">- Jumlah & Jenis Satuan<br>- Berat bersih (Kg)<br> - Volume (m3)</td>
  <td colspan="4">- Nilai CIF <br>- Harga Penyerahan </td>
</tr>
<?php for($i=0;$i<$countBarang;$i++):?>
<tr>
  <td align="center" class="noborderbtm"><?php echo $rsBarang[$i]['no'] ?> </td>
  <td class="noborderbtm" colspan="7"><?php echo $rsBarang[$i]['UrBarang']."<br>".$rsBarang[$i]['KdBarang'] ?></td>
  <td align="right" class="noborderbtm" colspan="5"><?php echo $rsBarang[$i]['qty']." ".$rsBarang[$i]['unit'] ?> &nbsp; &nbsp; &nbsp; </td>
  <td class="noborderrb">&nbsp;</td>
  <td class="noborderrb"><?php echo $rs[0]['KdVal'] ?></td>
  <td align="right" class="noborderrb"><?php echo number_format($rsBarang[$i]['HrgSerah'],2);?></td>
  <td align="right" class="noborderbtm">&nbsp;</td>
</tr>
<?php endfor; ?>
<tr height="100%">
  <td></td>
  <td colspan="7"></td>
  <td colspan="5"></td>
  <td colspan="4"></td>
</tr>
<tr>
  <td class="noborderright" colspan="8">&nbsp;</td>
  <td colspan="9"><b>E. TANDA TANGAN PENGUSAHA TPB</b></td>
</tr>
<tr>
  <td align="center" class="noborderright" colspan="8">&nbsp;<br><br><br><br><br></td>
  <td colspan="9">
  Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal<br>
  yang diberitahukan dalam pemberitahuan pabean ini.<br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; Subang, Tgl. <?php echo $rs[0]['tgl_daf'] ?><br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;( <?php echo $rs[0]['NmPengusaha'] ?> )</td>
</tr>
<tr>
  <td class="noborderlrb" colspan="17">Rangkap ke- 1/2/3 : Kantor Pabean / Pengusaha TPB / Pengirim Barang  </td>
</tr> 
</tbody>
</table>
<?php endif; if(count($rsDokPelengkap>0)): ?>
<table cellpadding="1" cellspacing="0" class="tablereport">
<tbody>
<tr>
  <td align="center" colspan="2"><h2>BC 4.0</h2></td>
  <td class="noborderright">&nbsp;</td>
  <td align="center" colspan="14"><h3>LEMBAR LAMPIRAN<br>DOKUMEN PELENGKAP PABEAN</h3></td>
</tr>
<tr>
  <td colspan="17"><b>HEADER</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">NOMOR PENGAJUAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderrb" colspan="4"><?php echo $rs[0]['FCAR'] ?></td>
  <td align="right" colspan="9">Halaman ... Dari ... <?php //if ($countBarang > 1){echo "3 Dari 3";}else{echo "2 Dari 2";}?>&nbsp; &nbsp; </td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">A. KANTOR PABEAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo $rs[0]['KdKpbcAsal'] ?></td>
  <td class="noborderbtm" colspan="9"><b>F. KOLOM KHUSUS BEA DAN CUKAI</b></td>
</tr>
<tr>
  <td class="noborderrb" colspan="3">B. JENIS TPB</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo getJnsTpb($rs[0]['KdJnsTpbAsal']) ?></td>
  <td class="noborderrb" colspan="2">Nomor Pendaftaran</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['FNoDaf'] ?>&nbsp;</span></td>
</tr> 
<tr>
  <td class="noborderrb" colspan="3">C. TUJUAN PENGIRIMAN</td>
  <td class="noborderrb">:</td>
  <td class="noborderbtm" colspan="4"><?php echo getTujKirim($rs[0]['KdTp']) ?></td>
  <td class="noborderright" colspan="2">Tanggal</td>
  <td class="noborderright">:</td>
  <td colspan="6"><span class="borderall">&nbsp;<?php echo $rs[0]['tgl_daf'] ?>&nbsp;</span></td>
</tr> 
<tr>
	<td class="nobordertr" width="10"></td>
    <td class="nobordertr" width="80"></td>
    <td class="nobordertr" width="30"></td>
    <td class="nobordertr" width="5"></td>
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr"></td>
    <td class="nobordertr" width="60"></td>    
    <td class="nobordert" width="50"></td> 
       
    <td class="nobordertr" width="50"></td>        
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr" width="5"></td>
    <td class="nobordertr"></td>
    <td class="nobordertr" width="40"></td>
    <td class="nobordertr" width="70"></td>
    <td class="nobordertr" width="50"></td>
    <td class="nobordertr" width="30"></td>
    <td class="nobordert" width="20"></td>
</tr>
<tr>
  <td align="center" width="20">NO.</td>
  <td class="noborderright"></td>
  <td colspan="6">JENIS DOKUMEN</td>
  <td align="center" colspan="5">NOMOR</td>
  <td align="center" colspan="4">TANGGAL</td>
</tr>
<?php for($i=0;$i<$countDokPelengkap;$i++):?>
<tr>
  <td align="center" class="noborderbtm"><?php echo $rsDokPelengkap[$i]['no'] ?></td>
  <td class="noborderbtm" colspan="7"><?php echo getUrKdJnsDok($rsDokPelengkap[$i]['DokKd'])?></td>
  <td align="center" class="noborderbtm" colspan="5"><?php echo $rsDokPelengkap[$i]['DokNo']?></td>
  <td align="center" class="noborderbtm" colspan="4"><?php echo $rsDokPelengkap[$i]['FDokTg']?></td>
</tr>
<?php endfor; ?>
<tr height="100%">
  <td></td>
  <td colspan="7"></td>
  <td colspan="5"></td>
  <td colspan="4"></td>
</tr>
<tr>
  <td class="noborderright" colspan="9">&nbsp;</td>
  <td colspan="8"><b>E. TANDA TANGAN PENGUSAHA TPB</b></td>
</tr>
<tr>
  <td class="noborderright"></td>
  <td class="noborderright"></td>
  <td align="center" class="noborderright" colspan="7">&nbsp;<br><br><br><br><br></td>
  <td colspan="8">
  Dengan ini saya menyatakan bertanggung jawab atas kebenaran hal-hal 
  yang diberitahukan dalam pemberitahuan pabean ini.<br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; Subang, Tgl. <?php echo $rs[0]['tgl_daf'] ?><br><br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;( <?php echo $rs[0]['NmPengusaha'] ?> )</td>
</tr> 
<tr>
  <td class="noborderlrb" colspan="17">Rangkap ke- 1/2/3 : Kantor Pabean / Pengusaha TPB / Pengirim Barang  </td>
</tr>
</tbody>
</table>
<?php endif; ?>
</body>
</html>