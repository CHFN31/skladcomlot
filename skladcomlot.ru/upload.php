<?php
// Проверяем, была ли отправлена форма
if(isset($_POST['submit'])) {
    // Проверяем, был ли выбран файл для загрузки
    if(!empty($_FILES['image']['name'])) {
        // Проверяем, является ли загруженный файл изображением
        $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if(in_array($fileType, $allowedTypes)) {
            // Подключаемся к базе данных
            $conn = mysqli_connect('localhost', 'root', '', 'storage');
            if(!$conn) {
                die("Ошибка подключения: " . mysqli_connect_error());
            }
            // Сохраняем файл на сервере
            $filePath = 'uploads/' . $_FILES['image']['name'];
            if(move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                // Подготавливаем запрос на добавление изображения в базу данных
                $imageData = mysqli_real_escape_string($conn, fread(fopen($filePath, "r"), filesize($filePath)));
                $sql = "INSERT INTO photos (name, image) VALUES (name, '$imageData')";
                $insertResult = mysqli_query($conn, $sql);
                if($insertResult) {
                    echo "Изображение успешно загружено";
                }
                else {
                    echo "Ошибка загрузки изображения: " . mysqli_error($conn);
                }
            }
            else {
                echo "Ошибка загрузки файла";
            }
            // Закрываем подключение к базе данных
            mysqli_close($conn);
        }
        else {
            echo "Недопустимый формат файла. Допустимы только файлы типов: " . implode(', ', $allowedTypes);
        }
    }
    else {
        echo "Файл не выбран";
    }
    
}
?>
