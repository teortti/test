<?php 
error_reporting(0);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}">
    <title>Добавление альбома</title>
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
    
    <div style="text-align: center; font-size: 40px; margin-top: 8%;"><b>ДОБАВЛЕНИЕ АЛЬБОМА</b></div>
<form method="POST" action="create" enctype="multipart/form-data" style="width: 19%; margin-top: 5%;">
     <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <input type="text" name="title" placeholder="Название альбома"><br>
    <input type="text" name="performer" placeholder="Испольнитель"><br>
    <textarea name="descr" placeholder="Описание"></textarea><br>
    Добавить обложку альбома:<input type="file" name="cover" placeholder="Изображение"><br>
    <input type="submit" name="add_album" value="ДОБАВИТЬ АЛЬБОМ"><br>
</form>
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