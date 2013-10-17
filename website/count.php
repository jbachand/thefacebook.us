<?php

$foldercount = 0;
$htmlcount = 0;
$htmllinecount = 0;
$phpcount = 0;
$phplinecount = 0;
$csscount = 0;
$csslinecount = 0;
$othercount = 0;


$path = $_SERVER["DOCUMENT_ROOT"]."/fb/";
$dir_handle = @opendir($path) or die("Unable to open $path");
count_dir($dir_handle,$path);

$totalcodefiles = $phpcount+$htmlcount+$csscount;
$totalcodelines = $phplinecount+$htmllinecount+$csslinecount;
$totalallfiles = $phpcount+$htmlcount+$csscount+$othercount;

$formattedfoldercount = number_format($foldercount);
$formattedphpcount = number_format($phpcount);
$formattedphplinecount = number_format($phplinecount);
$formattedhtmlcount = number_format($htmlcount);
$formattedhtmllinecount = number_format($htmllinecount);
$formattedcsscount = number_format($csscount);
$formattedcsslinecount = number_format($csslinecount);
$formattedothercount = number_format($othercount);
$formattedtotalcodefiles = number_format($totalcodefiles);
$formattedtotalcodelines = number_format($totalcodelines);
$formattedtotalallfiles = number_format($totalallfiles);

$htmloutput = "<html><head></head><body><table width='500'>";
$htmloutput.= "<tr><th colspan='3'>Directory Listing of $path</th></tr>";
$htmloutput.= "<tr><td></td><td></td><td></td></tr>";
$htmloutput.= "<tr><td><hr></td><td><hr></td><td><hr></td></tr>";
$htmloutput.= "<tr><td>Type</td><td># of Files</td><td># Lines of Code</td></tr>";
$htmloutput.= "<tr><td><hr></td><td><hr></td><td><hr></td></tr>";
$htmloutput.= "<tr><td>PHP</td><td>".$formattedphpcount."</td><td>".$formattedphplinecount."</td></tr>";
$htmloutput.= "<tr><td>HTML</td><td>".$formattedhtmlcount."</td><td>".$formattedhtmllinecount."</td></tr>";
$htmloutput.= "<tr><td>CSS</td><td>".$formattedcsscount."</td><td>".$formattedcsslinecount."</td></tr>";
$htmloutput.= "<tr><td><b>Code Files Totals</b></td><td><b>".$formattedtotalcodefiles."</b></td><td><b>".$formattedtotalcodelines."</b></td></tr>";
$htmloutput.= "<tr><td><hr></td><td><hr></td><td><hr></td></tr>";
$htmloutput.= "<tr><td>Other File Types</td><td>".$formattedothercount."</td><td>---</td></tr>";
$htmloutput.= "<tr><td><hr></td><td><hr></td><td><hr></td></tr>";
$htmloutput.= "<tr><td><b>Total Folders</b></td><td><b>".$formattedfoldercount."</b></td><td>---</td></tr>";
$htmloutput.= "<tr><td><b>Total Files</b></td><td><b>".$formattedtotalallfiles."</b></td><td>---</td></tr>";
$htmloutput.="</table></body></html>";

print $htmloutput;

function count_dir($dir_handle,$path)
{
    global $foldercount, $phpcount, $htmlcount, $csscount, $othercount;
    global $phplinecount, $htmllinecount, $csslinecount;
    //echo "<ol>";
    while (false !== ($file = readdir($dir_handle))) 
    {
        $dir =$path.'/'.$file;
        if(is_dir($dir) && $file != '.' && $file !='..' )
        {
            $handle = @opendir($dir) or die("undable to open file $file");
            //echo "<li>$file</li>";
            $foldercount++;
            count_dir($handle, $dir);
        }
        elseif($file != '.' && $file !='..')
        {
            $fileext = strstr_after($file, '.');
            switch($fileext) {
                case "html":
                    $htmlcount++;
                    $htmllinecount=$htmllinecount+count_lines($dir);
                    //echo "<li>$file</li>";
                    break;
                case "htm":
                    $htmlcount++;
                    $htmllinecount=$htmllinecount+count_lines($dir);
                    //echo "<li>$file</li>";
                    break;
                case "php":
                    $phpcount++;
                    $phplinecount=$phplinecount+count_lines($dir);
                    //echo "<li>$file</li>";
                    break;
                case "css":
                    $csscount++;
                    $csslinecount=$csslinecount+count_lines($dir);
                    //echo "<li>$file</li>";
                    break;
                default:
                    $othercount++;
                    break;
            }
        }
    }
   
    //echo "</ol>";

    //closing the directory
    closedir($dir_handle);
   
}

function count_lines($filename) {
    //$filename = str_replace("/","\\",$filename);
    $linecount = 0;
    $handle = @fopen($filename, "r");
    if ($handle) {
        while (($buffer = fgets($handle,16000)) !== false) {
            $linecount++;
        }
        if (!feof($handle)) {
            //$linecount = 0;
        }
        fclose($handle);
    }
    return $linecount;
}

function strstr_after($haystack, $needle, $case_insensitive = false) {
    $strpos = ($case_insensitive) ? 'stripos' : 'strpos';
    $pos = $strpos($haystack, $needle);
    if (is_int($pos)) {
        return substr($haystack, $pos + strlen($needle));
    }
    // Most likely false or null
    return $pos;
}


?>