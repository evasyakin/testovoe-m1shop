<?php
/**
 * @package evas-php/evas-loader
 */
namespace Evas\Loader;

/**
 * Загрузчик классов, интерфейсов, трейтов.
 * @author Egor Vasyakin <e.vasyakin@itevas.ru>
 * @since 1.0
 */
class Loader
{
    /**
     * @var string базовая директория загрузки
     */
    public $baseDir;

    /**
     * @var array директории автозагрузки
     */
    public $dirs = [];

    /**
     * @var array пространства имен для автозагрузки
     */
    public $namespaces = [];

    /**
     * Добавление директории автозагрузки.
     * @param string директория
     * @return $this
     */
    public function dir(string $dir)
    {
        $this->dirs[] = $dir;
        return $this;
    }

    /**
     * Добавление директорий автозагрузки.
     * @param array директории
     * @return $this
     */
    public function dirs(array $dirs)
    {
        $this->dirs = array_merge($this->dirs, $dirs);
        return $this;
    }

    /**
     * Добавление пространства имен для автозагрузки.
     * @param string пространство имен
     * @param string путь
     * @return $this
     */
    public function namespace(string $name, string $path)
    {
        $name = str_replace('\\', '\\\\', $name);
        $this->namespaces[$name] = $path;
        return $this;
    }

    /**
     * Добавление пространств имен для автозагрузки.
     * @param array маппинг пространств имен с путями
     * @return $this
     */
    public function namespaces(array $namespaces)
    {
        foreach ($namespaces as $name => $path) {
            $this->namespace($name, $path);
        }
        return $this;
    }

    /**
     * Обработчик автозагрузки.
     * @param string имя класса или интерфейса
     */
    public function autoload(string $className)
    {
        foreach ($this->namespaces as $name => $path) {
            if (preg_match("/^$name(?<class>.*)/", $className, $matches)) {
                if ($this->load($path . $matches['class'] . '.php')) {
                    return;
                }
            }
        }

        $name = str_replace('\\', '/', $className) . '.php';
        foreach ($this->dirs as &$dir) {
            if ($this->load($dir . $name)) {
                return;
            }
        }
    }

    /**
     * Загрузка файла.
     * @param string имя файла
     * @return bool удалось ли загрузить
     */
    public function load(string $filename): bool
    {
        $filename = "$this->baseDir/$filename";
        if (is_readable($filename)) {
            include $filename;
            return true;
        }
        return false;
    }

    /**
     * Запуск автозагрузки.
     */
    public function run()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * Остановка автозагрузки.
     */
    public function stop()
    {
        spl_autoload_unregister([$this, 'autoload']);
    }

    /**
     * Конструктор.
     * @param string|null базовая директория загрузки
     */
    public function __construct(string $baseDir = null)
    {
        if (! $baseDir) {
            $baseDir = dirname($_SERVER['SCRIPT_FILENAME']);
        }
        $this->baseDir = $baseDir;
    }
}
