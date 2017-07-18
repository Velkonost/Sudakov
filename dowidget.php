<?php
/**
 * Сборка виджета
 *
 * Удаляет комментарии перед сборкой и создает архив
 */

// check extensions
if (!extension_loaded('zip')) {
    ech("The Zip php extension not installed!\n", 'red');
    exit;
} else if (!function_exists('simplexml_load_file')) {
    ech("The SimpleXml php extension not installed!\n", 'red');
    exit;
}

// парсим аргументы
$arguments = [];
foreach ($argv as $arg) {
    $arg = explode('=', $arg, 2);
    if (!isset($arg[1])) continue;
    $arguments[ $arg[0] ] = trim($arg[1], ' "');
}

$widgetFolder = __DIR__ . '/widget';
$tmpFolder = __DIR__ . '/tmp/widget_copy';


// читаем текущий manifest.json
if (!is_file($widgetFolder . '/manifest.json')) {
    ech("Not found {$widgetFolder}/manifest.json\n", 'red');
    exit(1);
}
$manifest = file_get_contents($widgetFolder . '/manifest.json');
$manifest = json_decode($manifest, true);
if (!is_array($manifest) || empty($manifest)) {
    ech("JSON file {$widgetFolder}/manifest.json is corrupted.\n", 'red');
    exit(2);
}

$DEV = 'false';
$version = isset($manifest['widget']['version']) ? $manifest['widget']['version'] : '0.0.1';
$lastCode = isset($manifest['widget']['code']) ? $manifest['widget']['code'] : 'insta01';
$lastKey = isset($manifest['widget']['secret_key']) ? $manifest['widget']['secret_key'] : '';

// запрашиваем ID виджета и секретный ключ
if (!isset($arguments['code']) && !isset($arguments['skey'])) {
    $widgetCode = readLn("Enter widget code [{$lastCode}]: ");
    $widgetCode = empty($widgetCode) ? $lastCode : $widgetCode;
    $secretKey = readLn("Enter widget secret key" . ($lastKey ? ' [' . $lastKey . ']' : '') . ": ");
    $secretKey = empty($secretKey) ? $lastKey : $secretKey;
    // ну и версию за одно
    $newVersion = readLn("Enter widget version [{$version}]: ");
    $newVersion = empty($newVersion) ? $version : $newVersion;
    // версия для разработчика
    $isDev = readLn("DEV version (y/n)? [n]: ");
    $DEV = ($isDev == 'y') ? 'true' : 'false';
} else {
    $widgetCode = $arguments['code'];
    $secretKey = $arguments['skey'];
    $version = isset($arguments['version']) ? $arguments['version'] : $version;
    $DEV = isset($arguments['dev']) ? $arguments['dev'] : 'false';
}

if (empty($widgetCode) || empty($secretKey)) {
    ech("Wrong arguments!\n", 'red');
    exit(10);
}

// подставляем widget ID и secret key в оригинальный manifest.json
$manifest['widget']['code'] = $widgetCode;
$manifest['widget']['secret_key'] = $secretKey;
$manifest['widget']['version'] = $newVersion;
$manifest = json_encode($manifest, JSON_PRETTY_PRINT);
file_put_contents($widgetFolder . '/manifest.json', $manifest);

// делаем копию всей папки виджета
if (is_dir($tmpFolder)) {
    dropDirectory($tmpFolder);
}
ech('Doing a widget copy...', 'green');
if (!copyDirectory($widgetFolder, $tmpFolder)) {
    ech("red\n", 'red');
}
ech("OK\n", 'green');

// сканируем все файлы виджета
$allFiles = scanDirectory($tmpFolder);

// удаляем однострочные комментарии из .js и .php
foreach ($allFiles as $file) {
    if (is_file($file)) {
        $details = pathinfo($file);
        if (in_array($details['extension'], ['php', 'js'])) {
            $content = file($file);
            foreach ($content as $k => $line) {
                $clear = trim($line);
                if (substr($clear, 0, 2) == '//') {
                    unset($content[$k]);
                }
            }
            $content = implode("", $content);
            $content = str_replace('__DEV__', $DEV, $content);
            file_put_contents($file, $content);
        }
    }
}

// архивация zip {$destinationZip}
$destinationZip = __DIR__ . '/tmp/' . (isset($arguments['zipname']) ? $arguments['zipname'] : 'widget') . '.zip';
if (zipping($tmpFolder, $destinationZip)) {
    // удаляем копию
    dropDirectory($tmpFolder);
    ech("Done! Widget package: {$destinationZip}\n", 'green');
} else {
    exit(5);
}


// === helpers ===

/**
 * @param string $prompt
 * @return string
 */
function readLn($prompt = '> ')
{
    if (PHP_OS == 'WINNT') {
        echo $prompt;
        $line = stream_get_line(STDIN, 1024, PHP_EOL);
    } else {
        $line = readline($prompt);
    }
    return $line;
}

/**
 * @param String $str
 * @param String $color 'black', 'dark_gray', 'blue', 'light_blue', 'green', 'light_green',
 *      'cyan', 'light_cyan', 'red', 'light_red', 'purple', 'light_purple', 'brown', 'yellow', 'light_gray', 'white'
 * @param String $background 'black', 'red', 'green', 'yellow', 'blue', 'magenta', 'cyan', 'light_gray'
 */
function ech($str, $color = '', $background = '')
{
    if (defined('NO_ECH')) return;
    $colors = ['black' => '0;30', 'dark_gray' => '1;30', 'blue' => '0;34',
        'light_blue' => '1;34', 'green' => '0;32', 'light_green' => '1;32',
        'cyan' => '0;36', 'light_cyan' => '1;36', 'red' => '0;31',
        'light_red' => '1;31', 'purple' => '0;35', 'light_purple' => '1;35',
        'brown' => '0;33', 'yellow' => '1;33', 'light_gray' => '0;37', 'white' => '1;37'];
    $backgrounds = ['black' => '40', 'red' => '41', 'green' => '42', 'yellow' => '43',
        'blue' => '44', 'magenta' => '45', 'cyan' => '46', 'light_gray' => '47'];
    if (!empty($colors[$color])) {
        $str = "\033[" . $colors[$color] . "m" . $str;
    }
    if (!empty($backgrounds[$background])) {
        $str = "\033[" . $backgrounds[$background] . "m" . $str;
    }
    echo $str . "\033[0m";
}

/**
 * Create directory
 * @param $dir
 * @return bool
 */
function createDirectory($dir)
{
    if (!file_exists($dir)) {
        // create all path levels for checking each directory from path
        $tokens = explode('/', trim($dir, '/'));
        $length = count($tokens);
        for ($i = 0; $i < $length; $i++) {
            $path = '/' . implode('/', array_slice($tokens, 0, $i + 1));
            if (!file_exists($path) && !mkdir($path, 0755)) {
                ech("Error: can't create directory {$path} of {$dir}\n", 'red');
                return false;
            }
        }
    }
    return true;
}


/**
 * Copy directory with files
 * @param String $source
 * @param String $dest
 * @return bool
 */
function copyDirectory($source, $dest)
{
    if (!createDirectory($dest)) {
        return false;
    }
    foreach (
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item
    ) {
        if ($item->isDir()) {
            mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        } else {
            copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        }
    }
    return true;
}


/**
 * Delete files in some directory
 * @param string $dir
 * @return boolean
 */
function clearDirectory($dir)
{
    $dir = str_replace('//', '/', $dir);
    $sys = ['/bin', '/boot', '/build', '/cdrom', '/dev', '/etc', '/lib', '/lib64', '/lost+found', '/media',
        '/mnt', '/opt', '/proc', '/root', '/run', '/sbin', '/srv', '/sys', '/tmp', '/usr'];
    foreach ($sys as $v) {
        if (substr($dir, 0, strlen($v)) == $v) {
            ech(" Error: you can't clear system directory!\n", "red");
            return false;
        }
    }
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            clearDirectory($file);
            @rmdir($file);
        } else {
            if (strpos($file, '.gitignore') === false) {
                unlink($file);
            }
        }
    }
    return true;
}


/**
 * Delete directory (with files)
 */
function dropDirectory($dir)
{
    if (clearDirectory($dir)) {
        rmdir($dir);
        return true;
    }
    return false;
}


/**
 * Scan directory and return all sub-folders and files
 */
function scanDirectory($path)
{
    $i = 0;
    $files = glob($path . '/*') + glob($path . '/*');
    while (isset($files[$i])) {
        $file = $files[$i];
        if (is_dir($file)) {
            $files = array_merge($files, glob($file.'/*') + glob($file.'/*.*'));
        }
        $i++;
    }
    return $files;
}


/**
 * Zipping directory
 *
 * @param string $sourceDir The file for zipping
 * @param string $destinationFile The Archive file name
 * @param bool $overwrite By default is true
 * @param string $arcRootPath path in archive as root for files
 * @return bool true on success
 */
function zipping($sourceDir = '', $destinationFile = '', $overwrite = true, $arcRootPath = '/')
{
    if (file_exists($destinationFile) && !$overwrite) {
        return false;
    }
    $sourceDir = rtrim($sourceDir, '/\\') . '/';
    $files = glob($sourceDir . '*') + glob($sourceDir . '*.*'); // read files list BEFORE create arc file
    $zip = new \ZipArchive();
    if (is_file($destinationFile) && $overwrite === true) {
        @unlink($destinationFile);
    }
    $ret = $zip->open($destinationFile, \ZipArchive::CREATE);
    if ($ret !== TRUE) {
        ech('  Error! Can\'t create zip file ' . $destinationFile . "  ", 'red');
        switch ($ret) {
            case \ZipArchive::ER_EXISTS:
                ech(" 'File already exists.'\n", 'red');
                break;
            case \ZipArchive::ER_INCONS:
                ech(" 'Zip archive inconsistent.'\n", 'red');
                break;
            case \ZipArchive::ER_INVAL:
                ech(" 'Invalid argument.'\n", 'red');
                break;
            case \ZipArchive::ER_MEMORY:
                ech(" 'Malloc failure.'\n", 'red');
                break;
            case \ZipArchive::ER_NOENT:
                ech(" 'No such file.'\n", 'red');
                break;
            case \ZipArchive::ER_NOZIP:
                ech(" 'Not a zip archive.'\n", 'red');
                break;
            case \ZipArchive::ER_OPEN:
                ech(" 'Can't open file.'\n", 'red');
                break;
            case \ZipArchive::ER_READ:
                ech(" 'Read error.'\n", 'red');
                break;
            case \ZipArchive::ER_SEEK:
                ech(" 'Seek error.'\n", 'red');
                break;
        }
        return false;
    } else {
        $count = count($files);
        for ($i = 0; $i < $count; $i++) { // foreach work incorrect with array_merge
            $file = $files[$i];
            if (strpos($file, '.gitignore') !== false) {
                continue;
            }
            if (is_dir($file)) {
                $dir = str_replace($sourceDir, $arcRootPath, $file);
                ech("     add folder " . $dir . " ... ", 'light_blue');
                if ($zip->addEmptyDir($dir)) {
                    ech("ok\n", 'light_blue');
                } else {
                    ech("error\n", 'red');
                }
                $subFiles = glob($file . '/*') + glob($file . '/*.*');
                $files = array_merge($files, $subFiles);
                $count = count($files);
            } else {
                $relPath = str_replace($sourceDir, $arcRootPath, $file);
                ech("     add file " . $relPath . " ... ", 'light_blue');
                if ($zip->addFile($file, $relPath)) {
                    ech("ok\n", 'light_blue');
                } else {
                    ech("error\n", 'red');
                }
            }
        }
        $zip->close();
    }
    return true;
}