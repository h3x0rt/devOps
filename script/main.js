
function openDialogAuth() {
    const auth = document.getElementById('auth-dialog');
    auth.classList.add('active');
}
function closeDialogAuth() {
    const auth = document.getElementById('auth-dialog');
    auth.classList.remove('active');
    document.getElementById('auth-error-message').textContent = '';
}
function logoutDialog(){
    const logout = document.getElementById('logoutDialog');
    logout.classList.add('active');
}
function closeLogoutDialog(){
    const logout = document.getElementById('logoutDialog');
    logout.classList.remove('active');
}
function openDialogReg() {
    const auth = document.getElementById('reg-dialog');
    auth.classList.add('active');
}
function closeDialogReg() {
    const auth = document.getElementById('reg-dialog');
    auth.classList.remove('active');
    document.getElementById('register-error-message').textContent = '';
}

document.getElementById('auth-dialog')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeDialogAuth();
    }
});
document.getElementById('reg-dialog')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeDialogReg();
    }
});
document.getElementById('logoutDialog')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeLogoutDialog();
    }
});

const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
const nav = document.querySelector('nav');
mobileMenuToggle?.addEventListener('click', function() {
    this.classList.toggle('active');
    nav.classList.toggle('active');
    // Анимация бургер-иконки
    if (nav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

// Закрытие меню при клике на пункт
document.querySelectorAll('.nav-button').forEach(button => {
    button.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            mobileMenuToggle.classList.remove('active');
            nav.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
//Редактирование записи
function openEdit(){
    const edit = document.getElementById('editDialog');
    edit.classList.add('active');
}
document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    const id = btn.dataset.id;
    const table = btn.dataset.table;

    fetch('php/fetch_record.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}&table=${table}`
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-table').value = table;

        const fieldsDiv = document.getElementById('edit-fields');
        fieldsDiv.innerHTML = '';

        for (const [key, value] of Object.entries(data.record)) {
            if (key === 'ID') continue;
            const fieldLabel = document.createTextNode(key + ': ');
            if (data.dropdowns && data.dropdowns[key]) {
                const select = document.createElement('select');
                select.name = key;

                data.dropdowns[key].forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.text = opt.label;
                    if (opt.id == value) option.selected = true;
                    select.appendChild(option);
                });

                fieldsDiv.appendChild(fieldLabel);
                fieldsDiv.appendChild(select);
            } else {
                const input = document.createElement('input');
                input.name = key;
                input.value = value;
                fieldsDiv.appendChild(fieldLabel);
                fieldsDiv.appendChild(input);
            }

        }
        document.getElementById('editDialog').classList.add('active');
    });
  });
});

// Закрытие модального окна
function closeEdit(){
    document.getElementById('editDialog').classList.remove('active');
}
document.getElementById('editDialog')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeEdit();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('scrollToTopBtn');
    const target = document.getElementById('main-content'); // основной блок

    function toggleScrollButton() {
        const targetTop = target.getBoundingClientRect().top;
        if (targetTop < window.innerHeight) {
            btn.style.display = 'block';
        } else {
            btn.style.display = 'none';
        }   
    }

    window.addEventListener('scroll', toggleScrollButton);
    toggleScrollButton(); // начальная проверка

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
function delete_row_dialog(){
    const darkened = document.getElementById('delete_row');
    darkened.classList.add('active');
}
//Проверка на вход
$.get('php/check_session.php', function(data) {
    if (data.authenticated) {
        authorized();
    }
});
function authorized(){
    document.getElementById('auth-buttons').style.display = 'none';
    document.getElementById('authorized').style.display = 'flex';
}
//Удаление записи
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            if (!confirm("Удалить запись?")) return;

            const form = this.closest("form");
            const table = form.querySelector("input[name='table']").value;
            const id = form.querySelector("input[name='id']").value;

            fetch("php/delete_row.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `table=${encodeURIComponent(table)}&id=${encodeURIComponent(id)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.closest("tr").remove();
                } else {
                    alert("Ошибка при удалении");
                }
            })
            .catch(error => {
                alert("Ошибка сети: " + error);
            });
        });
    });
});
//Выход с аккаунта
$(document).ready(function() {
    $("#logoutAlert").on("submit", function(e) {
        e.preventDefault(); // Отменяем стандартную отправку формы
        // Получаем данные из полей
        // Отправляем AJAX-запрос
        $.ajax({
            url: "php/logout.php",
            type: "POST",
            success: function(response) {
                document.getElementById('auth-buttons').style.display = 'flex';
                document.getElementById('authorized').style.display = 'none';
                closeLogoutDialog();
                
            },
            error: function(xhr, status, error) {
                $("#logoutAlert").html("Произошла ошибка при регистрации.");
                alert("Произошла ошибка");
            }
        });
    });
});
//ajax register
$(document).ready(function() {
    $("#register").on("submit", function(e) {
        e.preventDefault(); // Отменяем стандартную отправку формы

        // Получаем данные из полей
        let login = $("#login-reg").val();
        let password = $("#password-reg").val();
        let passwordVerify = $("#password-verify-reg").val();
        
        // Отправляем AJAX-запрос
        $.ajax({
            url: "php/registration.php", // путь к твоему обработчику
            type: "POST",
            data: {
                login: login,
                password: password,
                password_verify: passwordVerify
            },
            success: function(response) {
                // Выводим ответ от сервера в сообщение
                $("#register-error-message").html(response.message);
            },
            error: function(xhr, status, error) {
                $("#register-error-message").html("Произошла ошибка при регистрации.");
            }
        });
    });
});

function checkWorkingHours() {
    const now = new Date();
    const day = now.getDay(); // 0 = воскресенье, 1 = понедельник, ..., 6 = суббота
    const hour = now.getHours();

    const isWorkingDay = day >= 1 && day <= 6; 
    const isWorkingHour = hour >= 8 && hour < 18;

    const status = (isWorkingDay && isWorkingHour)
        ? "Сейчас мы открыты"
        : "Сейчас мы закрыты";

    document.getElementById("workStatus").textContent = status;
}

// Проверить при загрузке
checkWorkingHours();

// При необходимости — обновлять каждый час
setInterval(checkWorkingHours, 60 * 60 * 1000);
//ajax auth
$(document).ready(function() {
    $("#authorise").on("submit", function(e) {
        e.preventDefault(); // Отменяем стандартную отправку формы

        // Получаем данные из полей
        let login = $("#login-auth").val();
        let password = $("#password-auth").val();
        
        // Отправляем AJAX-запрос
        $.ajax({
            url: "php/auth.php", // путь к твоему обработчику
            type: "POST",
            data: {
                login: login,
                password: password,
            },
            success: function(response) {
                if(response.success){
                    closeDialogAuth();
                    $("#username").html(response.username);
                    alert("Авторизация успешна!");
                    authorized();
                    
                }
                // Выводим ответ от сервера в сообщение
                else{
                    $("#auth-error-message").html(response.message);
                }
                
            },
            error: function(xhr, status, error) {
                $("#auth-error-message").html("Произошла ошибка при авторизации.", error);
                alert("Произошла ошибка");
            }
        });
    });
});
