<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Все категории</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
    <div class="content">
        <h2 align="center">Категории товаров</h2>
        <div class="categories">
            <a href="proftruba.php"><div class="cat-card">
                <img src="img/proftruba.jpeg" alt="">
                <div class="cat-name">
                    Профильные трубы
                </div>
            </div></a>
            <a href="profnas.php"><div class="cat-card">
                <img src="img/032_original.jpg" alt="">
                <div class="cat-name">
                    Профнастил
                </div>
            </div></a>
            <a href="armatura.php"><div class="cat-card">
                <img src="img/armatura.png" alt="">
                <div class="cat-name">
                    Арматура
                </div>
            </div></a>
            <a href="services.php"><div class="cat-card">
                <img src="img/services.jpg" alt="">
                <div class="cat-name">
                    Наши услуги
                </div>
            </div></a>
            <a href="lattice.php"><div class="cat-card">
                <img src="img/150150 4.jpg" alt="">
                <div class="cat-name">      
                    Сетка
                </div>
            </div></a>
            <a href="screws.php"><div class="cat-card">
                <img src="img/gvozd.jpg" alt="">
                <div class="cat-name">
                    Саморезы/гвозди
                </div>
            </div></a>
            <a href="metalist.php"><div class="cat-card">
                <img src="img/metalist.jpg" alt="">
                <div class="cat-name">
                    Горячекатанные листы
                </div>
            </div></a>
            <a href="kraska.php"><div class="cat-card">
                <img src="img/kraska.jpg" alt="">
                <div class="cat-name">
                    Краска
                </div>
            </div></a>
            <a href="wire.php"><div class="cat-card">
                <img src="img/wire.jpg" alt="">
                <div class="cat-name">
                    Проволока
                </div>
            </div></a>
            <a href="osb.php"><div class="cat-card">
                <img src="img/osb.jpeg" alt="">
                <div class="cat-name">
                    OSB
                </div>
            </div></a>
            <a href="ugolok.php"><div class="cat-card">
                <img src="img/ugolok.jpg" alt="">
                <div class="cat-name">
                    Уголок металлический
                </div>
            </div></a>
            <a href="kist.php"><div class="cat-card">
                <img src="img/kist.jpg" alt="">
                <div class="cat-name">
                    Кисточки/Валики
                </div>
            </div></a>
            <a href="hydroparo.php"><div class="cat-card">
                <img src="img/hydro.jpg" alt="">
                <div class="cat-name">
                    Гидроизоляция и Пароизоляция
                </div>
            </div></a>
            <a href="varia.php"><div class="cat-card">
                <img src="img/Rastvoriteli.jpg" alt="">
                <div class="cat-name">
                    Разное
                </div>
            </div></a>
            <a href="shim.php"><div class="cat-card">
                <img src="img/shim.jpg" alt="">
                <div class="cat-name">
                    Шпильки/Шайбы/Гайки
                </div>
            </div></a>
            <a href="insulation.php"><div class="cat-card">
                <img src="img/insulation.jpg" alt="">
                <div class="cat-name">
                    Утеплитель
                </div>
            </div></a>
            <a href="clamp.php"><div class="cat-card">
                <img src="img/clamp.jpg" alt="">
                <div class="cat-name">
                    Хомуты
                </div>
            </div></a>
            <a href="contacts.php"><div class="cat-card">
                <img src="img/contacts.jpg" alt="">
                <div class="cat-name">
                    Контакты
                </div>
            </div></a>
        </div>
        
    </div>
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
    <script src="Script/main.js"></script>
    
</body>
</html>