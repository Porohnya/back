<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены.');
    }
    include('form.php');
    exit();
}
$errors = FALSE;
if (empty($_POST['name'])) {
    print('Заполни имя.<br/>');
    $errors = TRUE;
}
if (empty($_POST['email'])) {
    print('Заполни email.<br/>');
    $errors = TRUE;
}
if (empty($_POST['date'])) {
    print('Выбери дату.<br/>');
    $errors = TRUE;
}
if (empty($_POST['gender'])) {
    print('Выбери пол.<br/>');
    $errors = TRUE;
}
if (empty($_POST['limbs'])) {
    print('Выбери количество конечностей.<br/>');
    $errors = TRUE;
}
if (empty($_POST['select'])) {
    print('Выбери суперспособнос(ть/ти).<br/>');
    $errors = TRUE;
}
if (empty($_POST['bio'])) {
    print('Расскажи о себе.<br/>');
    $errors = TRUE;
}
if (empty($_POST['policy'])) {
    print('Ознакомся с политикой обработки данных.<br/>');
    $errors = TRUE;
}

if ($errors) {
    exit();
}

// Сохранение в базу данных.
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$gender = $_POST['gender'];
$limbs = $_POST['limbs'];
$bio = $_POST['bio'];
$policy = $_POST['policy'];
$powers = implode(',', $_POST['select']);

$user = 'u47526';
$pass = '3997705';
$db = new PDO('mysql:host=localhost;dbname=u47526', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
    $stmt = $db->prepare("INSERT INTO members SET name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ?");
    $stmt->execute(array($name, $email, $date, $gender, $limbs, $bio, $policy));
    $user_id = $db->lastInsertId();

    $superpowers = $db->prepare("INSERT INTO superpowers SET powers = ?, userID = ? ");
    $superpowers->execute(array($powers, $user_id));
} catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}
header('Location: ?save=1');
