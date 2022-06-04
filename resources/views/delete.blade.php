<?php 
$id=$_GET['id'];

DB::delete('delete from albums where id = ?',[$id]);
exit("<meta http-equiv='refresh' content='0; url= /'>");

?>