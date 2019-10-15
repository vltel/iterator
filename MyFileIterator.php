<?php

/**
 * MyFileIterator Class
 */
class MyFileIterator implements SeekableIterator
{
    /**
     * @var string  $handle
     * @var integer $position
     * @var integer $length
     */
    private $handle;     // файловый указатель
    private $position;   // текущая позиция
    private $length = 2; // длина чтения блока данных

    /**
     * MyFileIterator constructor.
     * @param string $file
     * @throws Exception
     */
    public function __construct($file)
    {
        // открываем файл на чтение
        if (file_exists($file)) {
            $this->handle = fopen($file, 'r');
            $this->position = 0;
        } else {
            throw new Exception('Файл не существует');
        }
    }

    public function __destruct() {
        // явно закрываем файл
        fclose($this->handle);
    }

    /**
     * @return string
     */
    public function current() {
        // читаем текущий блок
        $string = fread($this->handle, $this->length);
        return $string;
    }

    /**
     * @return int
     */
    public function key() {
        // получаем текущую позицию
        return $this->position;
    }

    /**
     * @return void
     */
    public function next() {
        // обновляем текущую позицию
        $this->position = ftell($this->handle);
    }

    /**
     * @return void
     */
    public function rewind() {
        // перемещаем позицию в начало
        rewind($this->handle);
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid() {
        // проверяем позицию
        return !feof($this->handle) ? true : false;
    }

    /**
     * @param int $position
     * @return void
     * @throws OutOfBoundsException
     */
    public function seek($position) {
        // перемещаемся на позицию $position
        if($this->valid()) {
            fseek($this->handle, $position);
            $this->position = $position;
        } else {
            throw new OutOfBoundsException("Ошибка позиции: {$position}");
        }
    }

}

