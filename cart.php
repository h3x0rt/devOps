<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    
    header("Location: index.php");
    exit;
}


$mysqli = new mysqli("localhost", "root", "", "diplom");
$mysqli->set_charset("utf8");

// Запрос всех товаров в корзине пользователя
$query = "
    SELECT 
        p.ID AS product_id,
        p.img,
        p.name,
        p.price,
        p.price_for,
        ci.quantity,
        pa.value AS attribute_value,
        a.name AS attribute_name
    FROM cartitems ci
    JOIN products p ON ci.product_id = p.ID
    LEFT JOIN productattributes pa ON pa.product_id = p.ID
    LEFT JOIN attributes a ON a.ID = pa.attribute_id
    WHERE ci.user_id = ?
";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {

    $pid = $row['product_id'];
    if (!isset($items[$pid])) { 
        $items[$pid] = [
            'name' => $row['name'],
            'img' => $row['img'],
            'price' => $row['price'],
            'price_for' => $row['price_for'],
            'quantity' => $row['quantity'],
            'attributes' => [],
        ];
    }
    $items[$pid]['attributes'][] = "{$row['attribute_name']}: {$row['attribute_value']}";
}

$total = 0;
foreach ($items as $item) {
    $total += $item['price'] * $item['quantity'];
}

$userId = $_SESSION['user_id'];
$orders = [];

$query = $mysqli->prepare("SELECT * FROM orders WHERE user_id = ? AND active = 1 ORDER BY created_at DESC");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();

while ($order = $result->fetch_assoc()) {
    $orders[] = $order;
}
$query->close();

// Получаем товары для заказов
$orderItems = [];

if (!empty($orders)) {
    $orderIds = implode(',', array_column($orders, 'ID'));

    $sqlItems = "
        SELECT oi.order_id, p.name, oi.quantity, oi.price, p.img
        FROM orderitems oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id IN ($orderIds)
    ";
    $resItems = $mysqli->query($sqlItems);

    while ($item = $resItems->fetch_assoc()) {
        $orderItems[$item['order_id']][] = $item;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Корзина</title>
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
            <a href="proftruba.php"><div class="nav-button ">Профильные трубы</div> </a>
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
    <h2>Корзина</h2>
    <div class="cart-page">
        


    
<?php  if (empty($items)): ?>
    <p>Ваша корзина пуста.</p>
<?php else: ?>
    <?php foreach ($items as $product_id => $item): ?>
        <div class="cart-item">
            <div class="cart-item-img">
                <img src="<?= htmlspecialchars($item['img']) ?>" alt="Фото">
            </div>
            <div class="cart-item-info">
                <div class="first-info">
                    <strong><?= htmlspecialchars($item['name']) ?></strong>
                    <span>Цена: <?= htmlspecialchars($item['price']) ?> ₽/<?php
                    $priceFor = $item['price_for'];
                    if ($priceFor === 'м2' || $priceFor === 'м²') {
                        $priceFor = 'м<sup>2</sup>';
                    }
                    echo $priceFor;
                    ?>
                    </span>
                </div>
                <div>
                    Введите количество:<br>
                    
                    <input type="number" name="quantity" class="quantity-input" data-price="<?= $item['price'] ?>"
                    data-product-id="<?= $product_id ?>"
                    value="<?= $item['quantity'] ?>"
                    min="1" ?> 
                </div>
                <div>
                    
                <?= implode("<br>", array_map('htmlspecialchars', $item['attributes'])) ?>

                </div>
                <div class="item-total" id="item-total-<?= $product_id ?>">
                    Общая цена:  <?= $item['price'] * $item['quantity'] ?> руб.
                </div>
            </div>
            
            <form class="delete-cart-form" data-product-id="<?= htmlspecialchars($product_id) ?>">
                <input type="hidden" name="product" value="<?= $product_id ?>">
                <button type="submit" class="delete-cart-item" title="Удалить товар">✕</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
        <p class="cart-total">Итого: <strong id="cart-total"><?= $total ?> руб.</strong></p>
        <p>
            Отправьте заявку и наш менеджер свяжется для дальнейшей обработки заказа
        </p>
        <form id="orderForm">
            
            <label for="phone">Введите номер телефона</label><input autocomplete="tel" id="phone" placeholder="+7 (___) ___-__-__"  required type="tel">
            
            <div class="alert-message">
                <span id="phoneValid"></span>
            </div>
            <button class="send-order-btn" type="submit">Отправить заявку</button>
        </form>
        <h2>Мои заказы</h2>
        
<?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <?php $orderSum = 0; ?>
        <div class="order-block">
            <div class="order-header">
                <h3>Заказ №<?= $order['ID'] ?> от <?= $order['created_at'] ?></h3>
                <p><strong>Статус:</strong> <?= htmlspecialchars($order['status']) ?></p>
            </div>

            <?php if (!empty($orderItems[$order['ID']])): ?>
                <?php foreach ($orderItems[$order['ID']] as $item): ?>
                    
                    <div class="order-item">
                        <div class="cart-image">
                            <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="cart-info">
                            <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
                            <p>Цена: <?= $item['price'] ?> ₽</p>
                            <?php $orderSum += ($item['price'] * $item['quantity'] ); ?>
                        </div>
                        <div class="cart-qty">
                            <p>Количество:</p>
                            <p><?= $item['quantity'] ?> шт.</p>
                        </div>
                        
                        <div class="cart-price">
                            Общая цена: <?= $item['price'] * $item['quantity'] ?> руб.
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет товаров в заказе.</p>
            <?php endif; ?>

            <div class="order-footer">
                <p><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Адрес:</strong> <?= htmlspecialchars($order['adress']) ?></p>
                <p><strong>Комментарий:</strong> <?= htmlspecialchars($order['remark']) ?></p>
                <p><strong>Итого:</strong> <?= $orderSum ?> рублей</p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>У вас пока нет заказов.</p>
<?php endif; ?>
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
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', () => {
        const quantity = parseInt(input.value) || 0;
        const price = parseFloat(input.dataset.price);
        const productId = input.dataset.productId;

        const itemTotal = quantity * price;
        document.getElementById('item-total-' + productId).textContent = 'Общая цена: ' + itemTotal + ' руб.';

        // Обновление общей суммы
        let total = 0;
        document.querySelectorAll('.quantity-input').forEach(i => {
            const q = parseInt(i.value) || 0;
            const p = parseFloat(i.dataset.price);
            total += q * p;
        });
        document.getElementById('cart-total').textContent = total + ' руб.';
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phone');

    function formatPhone(value) {
        const digits = value.replace(/\D/g, '').replace(/^7/, '');
        const parts = [];

        if (digits.length > 0) parts.push('(' + digits.substring(0, 3));
        if (digits.length >= 4) parts[0] += ')';
        if (digits.length >= 4) parts.push(digits.substring(3, 6));
        if (digits.length >= 7) parts.push(digits.substring(6, 8));
        if (digits.length >= 9) parts.push(digits.substring(8, 10));

        let formatted = '+7 ';
        if (parts.length > 0) formatted += parts[0];
        if (parts.length > 1) formatted += ' ' + parts[1];
        if (parts.length > 2) formatted += '-' + parts[2];
        if (parts.length > 3) formatted += '-' + parts[3];

        return formatted;
    }

    phoneInput.addEventListener('input', function () {
        const cursorPos = phoneInput.selectionStart;
        const prevLength = phoneInput.value.length;

        phoneInput.value = formatPhone(phoneInput.value);

        // Корректируем позицию курсора
        const newLength = phoneInput.value.length;
        phoneInput.setSelectionRange(cursorPos + (newLength - prevLength), cursorPos + (newLength - prevLength));
    });

    // Блокируем удаление префикса
    phoneInput.addEventListener('keydown', function (e) {
        if ((phoneInput.selectionStart <= 3) && (e.key === 'Backspace' || e.key === 'Delete')) {
            e.preventDefault();
        }
    });

    // Автоустановка курсора
    phoneInput.addEventListener('focus', function () {
        if (phoneInput.value.length < 4) {
            phoneInput.value = '+7 ';
            phoneInput.setSelectionRange(phoneInput.value.length, phoneInput.value.length);
        }
    });
});
document.getElementById('orderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const phone = document.getElementById('phone').value;

    if (phone.length === 18) {
        const quantities = {};
        const prices = {};

        document.querySelectorAll('.quantity-input').forEach(input => {
            const productId = input.dataset.productId;
            const quantity = input.value;
            const price = input.dataset.price;
            if (productId && quantity) {
                quantities[productId] = quantity;
                prices[productId] = price;
            }
        });

        const params = new URLSearchParams();
        params.append('phone', phone);

        for (const [productId, quantity] of Object.entries(quantities)) {
            params.append(`quantities[${productId}]`, quantity);
        }

        for (const [productId, price] of Object.entries(prices)) {
            params.append(`prices[${productId}]`, price);
        }

        fetch('php/send_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString()
        })
        .then(res => res.text())
        .then(data => {
            location.reload(); // или покажи сообщение об успешной отправке
        });

    } else {
        $('#phoneValid')
            .hide()
            .php("Некорректный номер телефона")
            .fadeIn(300)
            .delay(2000)
            .fadeOut(300);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.delete-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;

            fetch('php/remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product=${encodeURIComponent(productId)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Удалим элемент из DOM
                    this.closest('.cart-item').remove();
                    recalculateTotal();
                    // Можно обновить итоговую цену или вывести сообщение
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error('Ошибка удаления:', err);
                alert('Произошла ошибка при удалении');
            });
        });
    });
});
function recalculateTotal() {
    let total = 0;
    const items = document.querySelectorAll('.cart-item');

    // Суммируем все элементы
    items.forEach(item => {
        const input = item.querySelector('.quantity-input');
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value) || 0;
        total += price * quantity;

        // Обновим цену для одного товара
        const productId = input.dataset.productId;
        const itemTotal = document.getElementById('item-total-' + productId);
        if (itemTotal) {
            itemTotal.textContent = `Общая цена: ${price * quantity} руб.`;
        }
    });

    // Показываем сумму
    const totalElem = document.querySelectorAll('#cart-total');
    totalElem.forEach(elem => elem.textContent = `${total} руб.`);

    // Если корзина пуста
    if (items.length === 0) {
        document.querySelector('.cart-page').innerHTML = '<p>Ваша корзина пуста.</p>';
    }
}
document.querySelectorAll('.quantity-input').forEach(input => {
    // При потере фокуса (например, пользователь вышел из поля)
    input.addEventListener('blur', () => {
        if (!input.value || parseInt(input.value) < 1) {
            input.value = 1;
        }
        recalculateTotal();
    });

   
});
</script>
</body>
</html>