<?php 
error_reporting(0);

$edit_id=$_GET['edit_id'];

$connect=mysqli_connect('localhost', 'root', '', 'music_album_guide');
    $str_out_album="SELECT * FROM `albums` WHERE id=$edit_id";
    $run_out_album=mysqli_query($connect, $str_out_album);
    $out_album=mysqli_fetch_array($run_out_album);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}">
    <title>Изменение альбома <?php echo $out_album[title]; ?></title>
</head>
<body>
<!-- ШАПКА !-->
<header>
    <a href="/"><h1>ТЕСТОВОЕ ЗАДАНИЕ</h1></a>
    <?php 

    if (Auth::check()):

    ?>
   <div class="auth" style="width: 649px">Добро пожаловать, {{Auth::getUser()->name}}</div>
  <a href="logout"
   onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
   ВЫЙТИ
</a>

   <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
   </form>
<?php else: ?>

<a href="#registration"><div class="auth" style="width: 162px">РЕГИСТРАЦИЯ </div></a>
    <a href="#auth_form"><div class="auth">АВТОРИЗАЦИЯ</div></a>
 
    
<?php endif; ?>
</header>

<!-- КОНТЕНТ !--> 
<main>
    
    <div style="text-align: center; font-size: 40px; margin-top: 8%;"><b>ИЗМЕНЕНИЕ АЛЬБОМА <?php echo $out_album[title]; ?></b></div>
<form method="POST" enctype="multipart/form-data" style="width: 19%; margin-top: 5%;">
     <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <input type="text" name="title" placeholder="Название альбома" value="<?php echo $out_album[title]; ?>"><br>
    <input type="text" name="performer" placeholder="Испольнитель" value="<?php echo $out_album[performer]; ?>"><br>
    <textarea name="descr" placeholder="Описание" autocomplete="on"><?php echo $out_album[description]; ?></textarea><br>
    Добавить обложку альбома:<input type="file" name="cover" placeholder="Изображение"><br>
    <input type="submit" name="add_album" value="ОБНОВИТЬ АЛЬБОМ"><br>
</form>

<?php 


$title=$_POST['title'];
$performer=$_POST['performer'];
$descr=$_POST['descr'];
$add_album=$_POST['add_album'];

    $type_img=$_FILES['cover']['type'];
    $name_img=$_FILES['cover']['name'];
    $size_img=$_FILES['cover']['size'];
    $tmp_name_img=$_FILES['cover']['tmp_name'];
    $path_img="images/$name_img";

    $str_out_album="SELECT * FROM `albums` WHERE id=$edit_id";
    $run_out_album=mysqli_query($connect, $str_out_album);
    $out_album=mysqli_fetch_array($run_out_album);
 if ($name_img=='') {
      
      $name_img=$out_album['cover'];

      
   }
$username=Auth::getUser()->name;

if ($add_album) {
$str_upd_album="UPDATE `albums` SET `title`='$title',`performer`='$performer',`cover`='$name_img',`description`='$descr' WHERE id='$edit_id'";
$run_upd_album=mysqli_query($connect, $str_upd_album);
if ($run_upd_album) {
    if ($out_album['cover']!==$name_img) {
        move_uploaded_file($tmp_name_img, $path_img);
        echo "Данные обновлены. <a href='/'>Посмотреть</a>";
    Log::info('Данные об альбоме №'."$id".' были обновлены пользователем '."$username");
    }
    echo "Данные обновлены. <a href='/'>Посмотреть</a>";
    Log::info('Данные об альбоме №'."$id".' были обновлены пользователем '."$username");
}
else
{
    echo "Что-то пошло не так";
    print_r($str_upd_album);
}
}



?>

</main>
</body>
</html>


<!-- МОДАЛЬНОЕ ОКНО !-->

<div class="popup" id="auth_form">
    <div class="popup_body">
        <div class="popup_content">
            <a href="#" class="popup_close">X</a>
            <h4>АВТОРИЗАЦИЯ</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input id="email" type="email" class="reg_form_input @error('email') is-invalid @enderror" name="email" placeholder="Логин" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <input id="password" type="password" class="reg_form_input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Пароль">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <input type="submit" name="auth" value="ВОЙТИ" class="reg_form_input auth">
            </form>
            <div class="or_reg">Или <a href="#registration">зарегестрируйтесь</a></div>
        </div>
    </div>
</div>

<div class="popup" id="registration">
    <div class="popup_body">
        <div class="popup_content reg">
            <a href="#" class="popup_close">X</a>
            <h4>РЕГИСТРАЦИЯ</h4>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input id="name" type="text" class="reg_form_input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Имя" autofocus>
                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                 <input id="email" type="email" class="reg_form_input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Логин (эл. почта)">
                 @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <input id="password" type="password" class="reg_form_input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Пароль">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                 <input id="password-confirm" type="password" class="reg_form_input" name="password_confirmation" required autocomplete="new-password" placeholder="Подтверждение пароля">
                <input type="submit" name="reg" value="ЗАРЕГЕСТРИРОВАТЬСЯ" class="reg_form_input auth">
            </form>
            <div class="or_reg">Уже есть аккаунт?<a href="#auth_form">Войдите</a></div>

        </div>
    </div>


</div>