
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php 
        session_start();
        
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Главная</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background-color: #f9f9f9;
  color: #222;
}

.main {
  margin: 0 auto;
  padding: 40px 20px;
}

.main-img {
  width: 100%;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.main h2 {
  font-size: 24px;
  margin-top: 40px;
  color: #cc0000;
  border-left: 5px solid #cc0000;
  padding-left: 10px;
}

p {
  font-size: 16px;
  line-height: 1.6;
  margin-top: 10px;
  margin-bottom: 20px;
}

.index-content {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 20px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
  padding: 20px;
  margin: 20px 0;
}

.index-content-img {
  max-width: 300px;
  width: 100%;
  height: auto;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.index-content p {
  flex: 1;
  font-size: 18px;
  font-weight: 500;
  color: #333;
}

.content img:not(.main-img):not(.index-content-img) {
  width: 100%;
  margin-top: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
@media (max-width: 1170px) {
    .main-img{
        width: 90%;
        padding-left: 1%;
        padding-right: 1%;
        margin-left: 4%;
        margin-right: 4%;
    }
}
    </style>
</head>
<body id="dialog">
    <button id="scrollToTopBtn" title="Наверх"><i class="fa-solid fa-arrow-up"></i></button>
    <div id="logoutDialog" class="darkened-background">
        <form id="logoutAlert" class="logoutAlert">
            <h2>Подтвердите выход</h2>
            Вы уверены, что хотите выйти с аккаунтa?
            <button type="submit" class="auth-buttons show">ВЫХОД</button>
        </form>
    </div>
    <div id="auth-dialog" class="darkened-background">
        <form id="authorise" class="authorise" bindsubmit="">
            <h2 style="margin-top: 10px;">АВТОРИЗАЦИЯ</h2>
            <div class="input-wrapper">
                <i class="fas fa-user icon"></i>
                <input id="login-auth" class="inputs" type="text" required placeholder="Логин">
            </div>
            <div class="input-wrapper">
                <i class="fas fa-lock icon"></i>
                <input id="password-auth" class="inputs" type="password" required placeholder="Ваш пароль">
            </div>
            <div id="auth-error-message" class="auth-message"><span></span></div>
            <div class="modal-buttons">
                <button type="submit">Войти</button>
                <a onclick="closeDialogAuth(); openDialogReg()">Нет аккаунта? Регистрация</a>
            </div>
        </form>
    </div>
    <div id="reg-dialog" class="darkened-background">
        <form id="register" class="authorise" bindsubmit="">
            <h2 style="margin-top:10px;">РЕГИСТРАЦИЯ</h2>
            
            <div class="input-wrapper">
                <i class="fas fa-user icon"></i>
                <input id="login-reg" class="inputs" required type="text" placeholder="Введите логин">
            </div>
            <div class="input-wrapper">
                <i class="fas fa-lock icon"></i>
                <input id="password-reg" class="inputs" required type="password" placeholder="Введите пароль">
            </div>
            <div class="input-wrapper">
                <i class="fas fa-lock icon"></i>
                <input id="password-verify-reg" class="inputs" required type="password" placeholder="Подтвердите пароль">
            </div>
            <div id="register-error-message" class="reg-message"><span></span></div>
            <div class="modal-buttons">
                <button type="submit">Зарегистрироваться</button>
                <a onclick="closeDialogReg(); openDialogAuth()">Уже есть аккаунт? Войти</a>
            </div>
        </form>
    </div>
    <header id="main-content">
        <div class="content">
                <a href="index.php">
                    <div class="logo">
                        <span class="ug"><span style="color: rgb(255, 56, 56);">Ю</span>г</span>
                        <span class="belora"><span style="color: rgb(255, 56, 56);">Б</span>елора</span>
                        <span class="metall"><span style="color: rgb(255, 56, 56);">М</span>еталл</span>
                    </div>
                </a>
                <div class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            <div class="main-nav">
                <div class="search-nav">
                    <div class="search-container">
                        <form action="search.php" method="GET">
                            <input type="text" required name="search" placeholder="Профнастил C-8" id="search">
                            <button class="search-btn" type="submit">
                                <svg class="search-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="auth-buttons" id="authorized">
                        <div class="user-info">
                            <i class="fas fa-user"></i>
                            <span id="username" class="username"><?php echo $_SESSION['user_name']?></span>
                        </div>
                        <a href="cart.php"><div class="cart">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                xmlns="http://www.w3.org/2000/svg" class="cart-icon">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61l1.6-8.39H6" />
                            </svg>
                        </div></a>
                        <button onclick="logoutDialog()" class="auth-btn show">ВЫХОД</button>

                        
                    </div>
                    
                    <div class="auth-buttons" id="auth-buttons">
                        <button onclick="openDialogAuth()" id="auth-btn" class="auth-btn show">Вход</button>
                        <button onclick="openDialogReg()" id="reg-btn" class="reg-btn show">Регистрация</button>
                    </div>
                </div>
                <div class="header-info">
                    <span>+7 918 999-99-86<br>Для заказа по звонку</span>
                    
                </div>
            </div>

            
            
        </div>
    </header>
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <div id="workStatus" class="open-message">
            </div>
            
            <a href="proftruba.php" class="sidebar-btn">
                <span class="btn-text">Профильные трубы</span>
            </a>
            <a href="profnastil.php" class="sidebar-btn active">
                <span class="btn-text">Профнастил</span>
            </a>
            <a href="armatura.php" class="sidebar-btn">
                <span class="btn-text">Арматура</span>
            </a>
            <a href="lattice.php" class="sidebar-btn">
                <span class="btn-text">Сетка</span>
            </a>
            <a href="services.php" class="sidebar-btn">
                <span class="btn-text">Наши услуги</span>
            </a>
            <a href="contacts.php" class="sidebar-btn">
                <span class="btn-text">Контакты</span>
            </a>
            <a href="prochee.php" class="sidebar-btn">
                <span class="btn-text">Прочее</span>
            </a>
            <a href="clamp.php" class="sidebar-btn">
                <span class="btn-text">Хомуты</span>
            </a>
        </nav>
    </aside>
    <nav>
        <div class="content nav-content">
            <a href="proftruba.php"><div class="nav-button">Профильные трубы</div> </a>
            <a href="profnastil.php"><div class="nav-button">Профнастил</div></a>
            <a href="armatura.php"><div class="nav-button">Арматура</div></a>
            <a href="services.php"><div class="nav-button">Наши услуги</div></a>
            
                <div id="prochee">
                    <a class="nav-button" style="border: 0px; box-shadow: initial;"  href="prochee.php">Прочее</a>
                    <div class="showMore">
                        <div class="contentMore">
                            <dl><dt><a href="wire.php"><span>Проволока</span></a></dt><dd><a href="insulation.php"><span> Утеплитель</span></a></dd></dl>
                            <dl><dt><a href="metalist.php"><span>Горячекатаный лист</span></a></dt><dd><a href="screws.php"><span> Саморезы/Гвозди</span></a></dd></dl>
                            <dl><dt><a href="osb.php"><span>OSB</span></a></dt><dd><a href="kraska.php"><span> Краска</span></a></dd></dl>
                            <dl><dt><a href="ugolok.php"><span>Уголок метал.</span></a></dt><dd><a href="lattice.php"><span> Сетка</span></a></dd></dl>
                            <dl><dt><a href="kist.php"><span>Кисточки/Валики</span></a></dt><dd><a href="clamp.php">Хомуты</a></dd></dl>
                            <dl><dt style="width: 100%;"><a href="hydroparo.php"><span>Гидроизоляция и Пароизоляция</span></a></dt></dl>
                            <dl><dt style="width: 100%;"><a href="varia.php"><span>Разное</span> </a></dt></dl>
                            <dl><dt style="width: 100%;"><a href="shim.php"><span>Шпильки/Шайбы/Гайки</span> </a></dt></dl>
                        </div>
                    </div>
                </div>
            
            <a href="contacts.php"><div class="nav-button">Контакты</div></a>
        </div>

    </nav>
    <img class="main-img content main" src="img/newface.jpg" alt="">

    <section class="content main" id="home">
        <h2>У нас вы можете найти:</h2>
        <div class="index-content">
            <img src="img/polno.jpg" class="index-content-img" alt="Профильные трубы">
            <p>Большое количество профильных труб самых разных размеров!<br>Оптом и в розницу!</p>
        </div>

        <h2>Продажа строительных материалов</h2>
        <p>Наш каталог включает в себя разнообразные виды металлопродуктов высокого качества. Мы гарантируем надежность и соответствие стандартам.</p>

        <h2>Услуги аренды инструментов, а также доставки материалов</h2>
        <p>Наша компания предоставляет услуги, необходимые для комфортного строительства.</p>

        
        <div class="index-content">
            <img src="img/manipul.png" class="index-content-img" alt="Доставка и перевозки">
            <p>Доставки манипулятором, а также грузоперевозки</p>

        </div>
    
    </section>
    <footer>
        <div class="foot-block">

            <div class="foot">
                <a href="tel:+79189999986"><span class="phone">+7 918 999 99 86</span></a><br>
                <a href="tel:+79180000204"><span class="phone">+7 918 0000 204</span></a><br>
                <a href="tel:+79186666023"><span class="phone">+7 988 6666 023</span></a><br>

                <span>Электронная почта: </span><br>
                <span> xanikyan90@mail.ru</span><br>
                <span>Социальные сети:</span><br>
                <div style="display: flex; flex-wrap: wrap;">
                    <div class="social-links">
                        <a href="https://www.instagram.com/@khanikyan_zhanna" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://vk.com/ВАШ_АККАУНТ" target="_blank" title="VK">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="https://wa.me/ВАШ_НОМЕР" target="_blank" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://t.me/ВАШ_АККАУНТ" target="_blank" title="Telegram">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="foot">
                <span>График работы:</span><br>
                <span>ПН-СБ: 08:00 - 17:00</span><br>
                <span>ВС: выходной</span><br>
                <a href="admin.php">Вход администратора</a>
            </div>
            <div id="desc" class="foot">
                <span>Адрес отдела продаж:</span><br>
                Краснодарский край, г. Белореченск, ул. Железнодорожная, д. 107 <br>
                <span>Адрес склада:</span><br>
                Краснодарский край, Белореченский р-н, п. Новый, ул. Терновая, д. 3
            </div>
        </div>
        <div class="copyright">
            <span>&copy; 2025 Юг-Белора-Металл ИП Ханикян Артур Андроникович</span>
        </div>
    </footer>
    
    <script src="script/main.js"></script>
    
</body>
</html>