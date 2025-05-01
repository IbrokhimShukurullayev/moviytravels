<?php
// Токен вашего бота (получите у BotFather)
$token = '7424974828:AAEOy8CEJwLaJ3XQYxYtLk9UXmVHbvpwZhg';

// ID чата (группы), куда будут отправляться заявки
$chat_id = '-4267196528';

// Получаем данные из формы
$name = $_POST['name'];
$phone = $_POST['phone'];
$pixel = $_POST['pixel'];

// Формируем сообщение для Telegram
$message = "Имя:  $name\nТелефон:  $phone";

// URL для отправки сообщения через Telegram API
$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);

// Отправляем запрос к Telegram API
$response = file_get_contents($url);

// Проверяем результат отправки
if ($response) {
    // Парсим JSON-ответ от Telegram
    $response_data = json_decode($response, true);
    if ($response_data['ok']) {
        // Если отправка успешна, перенаправляем на thankyou.php с UTM-меткой
        header("Location: thankyou.php?name=" . $_POST['name'] . "&phone=" . $_POST['phone'] . "&pixel=" . $_POST['pixel']);
        exit;
    } else {
        // Если Telegram вернул ошибку
        echo "Произошла ошибка при отправке заявки. Пожалуйста, попробуйте позже.";
    }
} else {
    // Если запрос к Telegram не выполнился
    echo "Произошла ошибка при отправке заявки. Пожалуйста, попробуйте позже.";
}
?>