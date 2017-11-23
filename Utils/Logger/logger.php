<?
/*
 * Класс логгер
 * - пишет логи определенного размера
 * - после чего пересохраняет файл с датой в имени и начинает новый
 * - функция записи в лог принимает на вход сроки, массивы и объекты
 */
namespace ProjectName\Utils;

interface OutputInFile
{
    public function __construct($sPath);
    
    public function writeLog($mData);
}

class Logger implements OutputInFile
{
    const LOGGER_CHMOD = 0755;

    protected $sPath;
    
    protected $arOptions = array(
        'MESS_HR' => "\r\n".'--------------------------------------------'."\r\n",
        'TITLE' => 'Log from:',
        'MAX_FILESIZE' => 1024 * 200,
        'FOPEN_MODE' => 'a',
        'ARCHIVE_DATE_FORMAT' => 'Ymd_Hi'
    );
    
    public function __construct($sPath, $arOptions = FALSE)
    {
        $this->sPath = $_SERVER['DOCUMENT_ROOT'].$sPath;
        
        $this->checkFolder();
        
        if(is_array($arOptions) && !empty($arOptions))
        {
            foreach($arOptions as $sOption => $sValue)
            {
                if(!is_array($sValue) && !is_object($sValue))
                {
                    $this->arOptions[$sOption] = $sValue;
                }
            }
        }
    }
    
    public function writeLog($mData)
    {
        if(file_exists($this->sPath))
        {
            $this->checkFileSize($this->sPath);
        }

        $this->pushContentInFile($mData);
    }
    
    protected function pushContentInFile($mData)
    {
        if(!file_exists($this->sPath))
        {
            $fFile = fopen($this->sPath, 'w');
        }
        else
        {
            $fFile = fopen($this->sPath, $this->arOptions['FOPEN_MODE']);
        }
        
        fwrite($fFile, $this->getMessageText($mData));
        
        fclose($fFile);
    }
    
    protected function checkFileSize($sPath)
    {
        if(filesize($sPath) > $this->arOptions['MAX_FILESIZE'])
        {
            $sBasename = basename($sPath);
            
            $sName = str_replace('.', '_end_'.date($this->arOptions['ARCHIVE_DATE_FORMAT']).'.', $sBasename);
            
            $sModPath = str_replace($sBasename, $sName, $sPath);
            
            rename($sPath, $sModPath);
        }
    }
    
    protected function checkFolder()
    {
        if(!is_dir(dirname($this->sPath)))
        {
            if(!mkdir(dirname($this->sPath), static::LOGGER_CHMOD, TRUE))
            {
                throw new \Exception('ERROR: Could not find or create directory for log file.');
            }
        }
    }
    
    protected function getMessageText($mData)
    {
        $sMess = $this->arOptions['MESS_HR'];
        $sMess .= $this->arOptions['TITLE'].' '.date('Y-m-d h:i:s');
        $sMess .= $this->arOptions['MESS_HR'];
        $sMess .= $this->getMessageBody($mData);
        $sMess .= $this->arOptions['MESS_HR']."\r\n";
        
        return $sMess;
    }
    
    protected function getMessageBody($mData)
    {
        if(is_array($mData))
        {
            $arMessBody = array();
            
            foreach($mData as $sKey => $mItem)
            {
                $arMessBody[$sKey.': '] = $this->unpackData($mItem);
            }
            
            return implode("\r\n", $arMessBody);
        }
        elseif(is_object($mData))
        {
            return $this->unpackData($mData)."\r\n";
        }
        else
        {
            return $mData;
        }
    }
    
    protected function unpackData($mData)
    {
        return json_encode($mData);
    }
}
