<?php

$user = 'u47526';
$pass = '3997705';
$db = new PDO('mysql:host=localhost;dbname=u47526', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['delete'])) {
        $stmt = $db->prepare("SELECT * FROM members2 WHERE login = ?");
        $stmt->execute(array($_POST['delete']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            print('<p>Ошибка при удалении данных</p>');
        } else {
            $stmt = $db->prepare("DELETE FROM members2 WHERE login = ?");
            $stmt->execute(array($_POST['delete']));

            $powers = $db->prepare("DELETE FROM superpowers2 where user_login = ?");
            $powers->execute(array($_POST['delete']));
            header('Location: ?delete_error=0');
        }
    } else if (!empty($_POST['edit'])) {
        $user = 'u47526';
        $pass = '3997705';
        $member_id = $_POST['edit'];

        $db = new PDO('mysql:host=localhost;dbname=u47526', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("SELECT * FROM members2 WHERE login = ?");
        $stmt->execute(array($member_id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $values['name'] = $result['name'];
        $values['email'] = $result['email'];
        $values['birth'] = $result['date'];
        $values['gender'] = $result['gender'];
        $values['limbs'] = $result['limbs'];
        $values['bio'] = $result['bio'];
        $values['policy'] = $result['policy'];

        setcookie('user_id', $member_id, time() + 12 * 30 * 24 * 60 * 60);

        $powers = $db->prepare("SELECT * FROM superpowers2 WHERE user_login = ?");
        $powers->execute(array($member_id['login']));
        $result = $powers->fetch(PDO::FETCH_ASSOC);
        $values['select'] = $result['powers'];
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = $_POST['birth'];
        $gender = $_POST['gender'];
        $limbs = $_POST['limbs'];
        $bio = $_POST['bio'];
        $policy = $_POST['policy'];
        $select = implode(',', $_POST['select']);
        $user = 'u47526';
        $pass = '3997705';
        $db = new PDO('mysql:host=localhost;dbname=u47526', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

        $member_id = $_COOKIE['user_id'];

        try {
            $stmt = $db->prepare("SELECT login FROM members2 WHERE id = ?");
            $stmt->execute(array($member_id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            setcookie('login_value', $result['login'], time() + 12 * 30 * 24 * 60 * 60);

            $stmt = $db->prepare("UPDATE members2 SET name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ? WHERE login = ?");
            $stmt->execute(array($name, $email, $date, $gender, $limbs, $bio, $policy, $result['login']));

            $superpowers = $db->prepare("UPDATE superpowers2 SET powers = ? WHERE user_login = ? ");
            $superpowers->execute(array($select, $result['login']));
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
}

if (!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])) {
    try {
        $stmt = $db->prepare("SELECT * FROM admins WHERE login = ?");
        $stmt->execute(array($_SERVER['PHP_AUTH_USER']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    if (empty($result['password'])) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Неверный логин</h1>');
        exit();
    }

    if ($result['password'] != md5($_SERVER['PHP_AUTH_PW'])) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Неверный пароль</h1>');
        exit();
    }

    print('Вы успешно авторизовались и видите защищенные паролем данные.');

    $stmt = $db->prepare("SELECT * FROM members2");
    $stmt->execute([]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT powers, COUNT(*) as owners FROM superpowers2 GROUP BY powers");
    $stmt->execute();
    $powersCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Админка</title>
    <style>
        body {
            display: flex;
            jalign-items: flex-start;
            justify-content: space-between;
            flex-direction: column;
        }

        table {
            border-collapse: collapse;
        }

        table td {
            border: 2px solid #E3E6EC;
            border-collapse: collapse;
        }

        td,
        th {
            font-size: 13px;
            padding: 0px 8px;
        }

        table th {
            font-size: 15px;
            color: #fff;
            background: linear-gradient(90deg, #2da3a1, #a0befc);
            height: 30px;
        }
    </style>
</head>

<body>
    <div class="tables-block">
        <table>
            <tr>
                <th>Название силы</th>
                <th>Число обладателей</th>
            </tr>
            <?php
            if (!empty($powersCount)) {
                foreach ($powersCount as $value) {
            ?>
                    <tr>
                        <td><?php echo $value['powers'] ?></td>
                        <td><?php echo $value['owners'] ?></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <div class="records-list">
        <table>
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Дата рождения</th>
                <th>Пол</th>
                <th>Конечности</th>
                <th>Суперспособности</th>
                <th>Биография</th>
            </tr>
            <?php
            if (!empty($result)) {
                foreach ($result as $value) {
            ?>
                    <tr>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['email'] ?></td>
                        <td><?php echo $value['date'] ?></td>
                        <td><?php echo $value['limbs'] ?></td>
                        <td><?php echo $value['gender'] ?></td>
                        <td>
                            <?php
                            $powers = $db->prepare("SELECT * FROM superpowers2 where user_login = ?");
                            $powers->execute(array($value['login']));
                            $superpowers = $powers->fetch(PDO::FETCH_ASSOC);
                            echo $superpowers['powers'];
                            ?>
                        </td>
                        <td id="bio">
                            <?php echo $value['bio'] ?>
                        </td>
                        <td class="edit-buttons">
                            <form action="" method="post">
                                <input value="<?php echo $value['id'] ?>" name="edit" type="hidden" />
                                <button id="edit">Edit</button>
                            </form>
                        </td>
                        <td class="edit-buttons">
                            <form action="" method="post">
                                <input value="<?php echo $value['login'] ?>" name="delete" type="hidden" />
                                <button id="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "Записи не найдены";
            }
            ?>
        </table>
    </div>
    <?php if (!empty($_POST['edit'])) {
        include('adminchange.php');
    } ?>
</body>

</html>
