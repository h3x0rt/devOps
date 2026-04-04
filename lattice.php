<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diplom";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "SELECT 
            p.ID AS product_id, 
            p.name AS product_name, 
            p.price,
            p.img,
            p.price_for,
            c.name AS category, 
            a.name AS attribute_name,
            pa.value AS attribute_value 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.ID 
        LEFT JOIN productattributes pa ON p.ID = pa.product_id 
        LEFT JOIN attributes a ON pa.attribute_id = a.ID 
        ORDER BY p.ID";

$result = $conn->query($sql);

// Группировка продуктов по категориям
$products = [];

while ($row = $result->fetch_assoc()) {
    $category = $row['category'];
    $product_id = $row['product_id'];

    if (!isset($products[$category][$product_id])) {
        $products[$category][$product_id] = [
            'name' => $row['product_name'],
            'price' => $row['price'],
            'price_for' => $row['price_for'],
            'img' => $row['img'],
            'id' => $product_id,
            'attributes' => []
        ];
    }

    if ($row['attribute_name']) {
        $products[$category][$product_id]['attributes'][] = [
            'name' => $row['attribute_name'],
            'value' => $row['attribute_value']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Сетка</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
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
    <div class="content ">
        <div class="catalog">
            <?php if (isset($products['Сетка'])): ?>
                <?php foreach ($products['Сетка'] as $product): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="product-name">
                            <b><?= htmlspecialchars($product['name']) ?></b>
                        </div>
                        <div class="incard">
                            <dl><dt>Цена:</dt>
                                <dd class="price">
                                    <?= htmlspecialchars($product['price']) ?> ₽/<?php
                                    $priceFor = $product['price_for'];
                                    if ($priceFor === 'м2' || $priceFor === 'м²') {
                                        $priceFor = 'м<sup>2</sup>';
                                    }
                                    echo $priceFor;
                                    ?>
                                </dd>
                            </dl>
                            <?php foreach ($product['attributes'] as $attr): ?>
                                <dl class="attributes"><dt><?= htmlspecialchars($attr['name']) ?>:</dt><dd><?= htmlspecialchars($attr['value']) ?></dd></dl>
                            <?php endforeach; ?>
                            <button class="add-to-cart-btn" data-product-id="<?= htmlspecialchars($product['id']) ?>" data-quantity="6" title="Добавить в корзину">
                                Добавить в корзину
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет товаров в категории "Сетка".</p>
            <?php endif; ?>
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
    <script src="script/main.js"></script>
    <script>
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
  button.addEventListener('click', function () {
    const productId = this.dataset.productId;
    const quantity = this.dataset.quantity || 6;

    fetch('php/add_tocart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Обновить счетчик корзины, если нужно
      } else {
        alert('Ошибка: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Ошибка:', error);
      alert('Авторизуйтесь для использования корзины.');
    });
  });
});
</script>
</body>
</html>