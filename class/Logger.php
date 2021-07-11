<?php
// класс для работы с логами/файлами
class Logger {


    // функция записи логов в файл
    // Параметры: название файла, текст для записи                                        
    public static function write_log($filename = "log.log", $text = "") {

        // определяем IP клиента
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // определяем время
        $datetime = date("Y.m.d H:i:s");
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/".$filename, $datetime." ".$ip." - ".$text."\r\n", FILE_APPEND);
        return 1;
    }

    // другие функции

}

?>