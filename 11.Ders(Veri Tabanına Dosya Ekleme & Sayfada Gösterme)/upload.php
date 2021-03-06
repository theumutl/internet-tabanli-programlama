<?php
require 'Medoo.php';
 
// Using Medoo namespace
use Medoo\Medoo;
 
$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'itp',
	'server' => 'localhost',
	'username' => 'root',
	'password' => ''
]);

//koşullar: daha önce yüklenmemiş olmalı, boyut max 10mb olmalı, dosya resim dosyası olmalı ve uzantı jpg, png ve gif olabilir

$hedef_klasor="yuklenenler/";
$hedef_dosya=$hedef_klasor.basename($_FILES["fileToUpload"]["name"]);
$yuklemeyeUygunluk = 1;
$durum="";

//uygunluk kontrol dosya var mı
if(file_exists($hedef_dosya)){
    $yuklemeyeUygunluk=0;
    $durum.="Aynı dosya Var.";
}

//uygunluk kontrol boyut max 10mb mı (1 mb için x6 sıfır)
if($_FILES["fileToUpload"]["size"]>10000000){
    $yuklemeyeUygunluk=0;
    $durum.="Dosya boyutu 10MB üstünde.";
}

//uygunluk kontrol dosya resim mi
$resimKontrol=mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
echo $resimKontrol;
if(strpos($resimKontrol, "image") != false){
    $yuklemeyeUygunluk=0;
    $durum.="Resim dosyası değil.";
}

//dosya uzantı uygunluk
$resimDosyaTur = strtolower(pathinfo($hedef_dosya,PATHINFO_EXTENSION));
if($resimDosyaTur!="jpg" && $resimDosyaTur!="jpeg" && $resimDosyaTur!="png" && $resimDosyaTur!="gif"){
    $yuklemeyeUygunluk=0;
    $durum.="png, jpg, jpeg ve gif uzantılı olmalı.";
}

if($yuklemeyeUygunluk==1){
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $hedef_dosya)){
        $database->insert("kisiler", ["ad" => "Köpek","foto" => $hedef_dosya]);
        $sonEklenen = $database -> id();
        if($sonEklenen>0){
            header("Location:kisi.php");
        }
        // echo "Dosya ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " yüklendi.";
    }else {
        echo "Hata";
    }
}else{
    echo "Kriterler sağlanmadı!";
    echo $durum;
}
?>