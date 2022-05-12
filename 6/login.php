<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if (!empty($_SESSION['login'])) {
    header('Location: ./');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['logout'])) {
        session_destroy();
        $_SESSION['login'] = '';
        header('Location: ./?logout=1');
    }
    if (!empty($_GET['error'])) {
        if ($_GET['error'] == '1') {
            print('<div>Пользователя с таким логином не существует</div>');
        } else {
            print('<div>Неверный пароль</div>');
        }
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Авторизация</title>
        <style>
            body {
                background: linear-gradient(90deg, #2da3a1, #a0befc);
            }

            form {
                display: flex;
                flex-direction: column;
                width: 220px;
                margin: 80px auto;
                padding: 5px;
                border-radius: 5px;
                background-color: rgba(255, 255, 255, 0.4);
                box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.4);
            }

            form div {
                margin-bottom: 7px;
            }

            input {
                font-size: 17px;
                font-family: Arial;
            }
        </style>
    </head>

    <body>
        <form action="" method="POST">
            <div>
                Логин:<input name="login" />
            </div>
            <div>
                Пароль:<input name="pass" />
            </div>
            <input type="submit" value="Войти" />
        </form>
        </div>
    </body>

    </html>

<?php
} else {
    $user = 'u47526';
    $pass = '3997705';
    $db = new PDO('mysql:host=localhost;dbname=u47526', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    $user_login = $_POST['login'];
    $pass_hash = md5($_POST['pass']);

    try {
        $stmt = $db->prepare("SELECT * FROM members2 WHERE login = ?");
        $stmt->execute(array($user_login));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    if (empty($result['pass'])) {
        header('Location: ?error=1');
    } else if ($result['pass'] == $pass_hash) {

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['uid'] = $result['id'];

        header('Location: ./');
    } else {
        header('Location: ?error=2');
    }
}
