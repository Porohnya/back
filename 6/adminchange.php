<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(90deg, #2da3a1, #a0befc);
            display: flex;
            justify-content: center;
            flex-direction: column;
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

        .erros-block #messages div {
            margin-bottom: 7px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form method="POST" action="">
            <div class="block">
                <input type="text" class="form-control" name="name" placeholder="Ваше имя..." />
            </div>
            <div class=" block">
                <input type="text" class="form-control" name="email" placeholder="Ваш email..." />
            </div>
            <div class="block" id="date-block">
                <span class="block-title">Дата рождения</span>
                <input type="date" class="form-control" name="date" />
            </div>
            <div class=" block" id="gender-block">
                <span>Пол:</span>
                <div class="radios">
                    <div class="male-block">
                        <input class="form-check-input" type="radio" name="gender" value="m" />
                        <label class="form-check-label" for="male">Муж</label>
                    </div>
                    <div class="female-block">
                        <input class="form-check-input" type="radio" name="gender" value="f" />
                        <label class="form-check-label" for="female">Жен</label>
                    </div>
                </div>
            </div>
            <div class="block" id="limbs-block">
                <span class="block-title">Конечности:</span>
                <div class="radios">
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="1" />
                        <label class="form-check-label" for="male">1</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="2" />
                        <label class="form-check-label" for="female">2</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="3" />
                        <label class="form-check-label" for="female">3</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="4" />
                        <label class="form-check-label" for="female">4</label>
                    </div>
                    <div class="limbs-radio">
                        <input class="form-check-input" type="radio" name="limbs" value="m" />
                        <label class="form-check-label" for="female">>4</label>
                    </div>
                </div>
            </div>
            <div class="block">
                <span class="block-title">Ваши суперспособности</span>
                <select class="form-select form-select-lg mb-2" name="powers[]" multiple>
                    <option value="time">Остановка времени</option>
                    <option value="through">Прохождение сквозь стены</option>
                    <option value="inf">Бессмертие</option>
                    <option value="psycho">Захват Разума</option>
                </select>
            </div>
            <div class="block">
                <span class="block-title">Биография</span>
                <textarea class="form-control" placeholder="Расскажите о себе..." name="bio"></textarea>
            </div>
            <div class="form-check policy">
                <input class="form-check-input" type="checkbox" value="y" id="policy" name="policy" checked />
                <label class="form-check-label" for="policy">Согласен с
                    политикой обработки персональных данных*.</label>
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
