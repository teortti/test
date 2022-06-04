<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}">
    <title>Статус добавления</title>
</head>
<?
error_reporting(0);
 
class InsertAlbumController extends Controller {
  public function insertform(){
     return view('album_create');
  }
   
  public function insert(Request $request){
     $name = $request->input('album');

     $title=$_POST['title'];
$performer=$_POST['performer'];
$descr=$_POST['descr'];
$add_album=$_POST['add_album'];

    $type_img=$_FILES['cover']['type'];
    $name_img=$_FILES['cover']['name'];
    $size_img=$_FILES['cover']['size'];
    $tmp_name_img=$_FILES['cover']['tmp_name'];
    $path_img="images/$name_img";

if ($add_album) {
    if ($title && $performer && $descr && $name_img) {
         
      
        $str_add_album=DB::insert('insert into albums (title, description, performer, cover) values (?, ?, ?, ?)', [$title, $descr, $performer,$name_img]);
        if ($str_add_album) {
            move_uploaded_file($tmp_name_img, $path_img);
            exit("<meta http-equiv='refresh' content='0; url= /'>");
        }
        else
        {

            echo "<b>Произошла ошибка при добавлении</b>";
        }
 }
    else
    {
        echo "<b>Заполните все поля</b>";
    }
}

  }
}