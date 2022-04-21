<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Задание 4</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(90deg, #2da3a1, #a0befc);
        }

        .form-container {
            width: 400px;
            margin: 50px auto;
            padding: 15px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.4);
        }

        .block {
            margin-bottom: 7px;
        }

        #gender-block,
        #limbs-block {
            display: flex;
            justify-content: space-between;
        }

        .radios {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 70%;
            border-radius: 5px;
        }

        .btn-container {
            width: 100%;
            text-align: center;
        }

        .error {
            color: rgba(245, 46, 46, 1);
            box-shadow: 1px 2px 15px rgba(245, 46, 46, 0.5);
            background-color: #fff;
            max-width: 150px;
            margin-bottom: 5px;
        }

        .erros-block {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="erros-block">
        <?php
        if (!empty($messages)) {
            print('<div id="messages">');
            foreach ($messages as $message) {
                print($message);
            }
            print('</div>');
        }
        ?>
    </div>
    <div class="form-container">
        <form method="POST" action="">
            <div class="block">
                <input type="text" class="form-control" name="name" placeholder="Ваше имя..." <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>"/>
            </div>
            <div class=" block">
                <input type="text" class="form-control" name="email" placeholder="Ваш email..." <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
            </div>
            <div class="block" id="date-block">
                <span class="block-title">Дата рождения</span>
                <input type="date" class="form-control" name="date" <?php if ($errors['date']) { print 'class="error"';} ?> value="<?php print $values['date']; ?>"/>
            </div>
            <div class=" block" id="gender-block">
                <span>Пол:</span>
                <div class="radios">
                    <div class="male-block">
                        <input class="form-check-input" type="radio" name="gender" value="m" <?php if ($values['gender'] == 'm') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="male">Муж</label>
                    </div>
                    <div class="female-block">
                        <input class="form-check-input" type="radio" name="gender" value="f" <?php if ($values['gender'] == 'f') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="female">Жен</label>
                    </div>
                </div>
            </div>
            <div class="block" id="limbs-block">
                <span class="block-title">Конечности:</span>
                <div class="radios">
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="1" <?php if ($values['limbs'] == '1') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="male">1</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="2" <?php if ($values['limbs'] == '2') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="female">2</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="3" <?php if ($values['limbs'] == '3') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="female">3</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="4" <?php if ($values['limbs'] == '4') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="female">4</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="m" <?php if ($values['limbs'] == 'm') {print 'checked';}; ?>/>
                        <label class="form-check-label" for="female">>4</label>
                    </div>
                </div>
            </div>
            <div class="block">
                <span class="block-title">Ваши суперспособности</span>
                <select class="form-select form-select-lg mb-2" name="powers[]" multiple <?php if ($errors['powers']) {print 'class="error"';} ?>>
                    <option value="time" <?php $arr = explode(',', $values['powers']);
                                        if ($arr != '') {
                                            foreach ($arr as $value) {
                                                if ($value == 'time') {
                                                    print 'selected';
                                                }
                                            }
                                        }
                                        ?>>Остановка времени</option>
                    <option value="through" <?php $arr = explode(',', $values['powers']);
                                            if ($arr != '') {
                                                foreach ($arr as $value) {
                                                    if ($value == 'through') {
                                                        print 'selected';
                                                    }
                                                }
                                            } ?>>Прохождение сквозь стены</option>
                    <option value="inf" <?php $arr = explode(',', $values['powers']);
                                                if ($arr != '') {
                                                    foreach ($arr as $value) {
                                                        if ($value == 'inf') {
                                                            print 'selected';
                                                        }
                                                    }
                                                } ?>>Бессмертие</option>
                    <option value="psycho" <?php $arr = explode(',', $values['powers']);
                                                if ($arr != '') {
                                                    foreach ($arr as $value) {
                                                        if ($value == 'psycho') {
                                                            print 'selected';
                                                        }
                                                    }
                                                } ?>>Захват Разума</option>
                </select>
            </div>
            <div class="block">
                <span class="block-title">Биография</span>
                <textarea class="form-control" placeholder="Расскажите о себе..." name="bio" <?php if ($errors['bio']) {print 'class="error"';} ?>><?php print $values['bio']; ?></textarea>
            </div>
            <div class="form-check policy">
                <input class="form-check-input" type="checkbox" value="y" id="policy" name="policy" checked/>
                <label class="form-check-label" for="policy">Согласен с
                    <a href="#">политикой обработки персональных данных*</a>.</label>
            </div>
            <div class="btn-container">
                <button class="btn btn-primary" type="submit" id="send-btn">
                    Отправить
                </button>
            </div>
        </form>
    </div>
</body>

</html>
