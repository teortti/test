<?php
$connect=mysqli_connect('localhost', 'root', '', 'music_album_guide');
$str_out_album="SELECT * FROM `albums`";
$run_out_album=mysqli_query($connect, $str_out_album);
$out_album=mysqli_fetch_array($run_out_album);

$url='http://ws.audioscrobbler.com/2.0/';

$options1=array(
                'method' => 'album.getinfo',
                'api_key' => '349b8b4ba2caef68a43b1509934c8d8d',
                'artist' => 'Darkthrone',
                'album' => 'Transilvanian Hunger',
                'format' => 'json'
 );

//Для первого альбома
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($options1));

       $response=curl_exec($ch);
       $data=json_decode($response, true);
       curl_close($ch);
if ($_REQUEST['edit_id']=$out_album['id']) {
           $str_out_album="SELECT * FROM `albums`";
$run_out_album=mysqli_query($connect, $str_out_album);
       }

if ($_REQUEST['id']=$out_album['id']) {
           echo "";
       }

       if ($data['album']['name']!==$out_album['title']) {
    $str_add_album="INSERT INTO `albums`(`title`, `performer`, `cover`, `description`) VALUES ('".$data['album']['name']."','".$data['album']['artist']."','274px-Transilvanianhunger.jpg','Transilvanian Hunger is the fourth album by Darkthrone')";
        $run_add_album=mysqli_query($connect, $str_add_album);
       }


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}">
    <title>Список пластинок</title>
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
    <?php 


    ?>
    <?php while($out_album=mysqli_fetch_array($run_out_album)): ?>
    <div class="shadow">
        <div class="flex_wrapper">
            <img class="album_image" src="images/<?php echo $out_album['cover']; ?>">
            <div class="album_info"><?php echo $out_album['title']; ?></div>
            <div class="album_info"><?php echo $out_album['performer']; ?></div>
            <div class="album_info" style="width: 28%;"><?php echo $out_album['description']; ?></div>
            <?php if(Auth::check()): ?>
            <a href="edit?edit_id=<?php echo $out_album['id']; ?>" style="width: 14px;"><img src="images/pen-solid.svg" width="110%" height="2%"></a>
           <a href="delete?id=<?php echo $out_album['id']; ?>" style="width: 39px;"><img src="images/xmark-solid.svg" width="35%" height="2%"></a>
       <?php else: ?>
        <div style="width: 200px"><a href="#auth_form">Войдите</a> или <a href="#registration">зарегестрируйтесь</a>, чтобы изменять и удалять альбом</div>
    <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>

<a href="add_album">
<div class="add_album">ДОБАВИТЬ АЛЬБОМ</div>
</a>

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