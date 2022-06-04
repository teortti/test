<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
error_reporting(0);


class UpdateAlbumController extends Controller {
public function show($id) {
   $id=$_GET['id'];
     $users = DB::select('select * from albums where id = ?',[$id]);
     return view('albums_update',['albums'=>$albums]);
  }

  public function edit_album(Request $id) {
$id=$_GET['id'];
$title=$_POST['title'];
$performer=$_POST['performer'];
$descr=$_POST['descr'];
$add_album=$_POST['add_album'];

    $type_img=$_FILES['cover']['type'];
    $name_img=$_FILES['cover']['name'];
    $size_img=$_FILES['cover']['size'];
    $tmp_name_img=$_FILES['cover']['tmp_name'];
    $path_img="images/$name_img";

 if ($name_img=='') {
      $str_out_album="SELECT * FROM `albums` WHERE id=$id";
    $run_out_album=mysqli_query($connect, $str_out_album);
    $out_album=mysqli_fetch_array($run_out_album);
      $name_img=$out_album['cover'];
   }
$connect=mysqli_connect('localhost', 'root', '', 'music_album_guide');
$str_upd_album="UPDATE `albums` SET `title`='$title',`performer`='$performer',`cover`='$name_img',`description`='$descr' WHERE id='$id'";
$run_upd_album=mysqli_query($connect, $str_upd_album);

  /* DB::table('albums')
            ->where('id', $id)
            ->update(['title' => $title, 'performer' => $performer, 'cover' => $name_img, 'description' => $descr]);

/*DB::update('update albums set title = ?, performer = ?, cover = ?, description = ? where id = ?',[$title, $performer, $name_img, $descr,$id]);*/

      move_uploaded_file($tmp_name_img, $path_img);
      //exit("<meta http-equiv='refresh' content='0; url= /'>");
print_r($str_upd_album);
  }
}