<?php

function subdoscan(){
    include 'main/config.php';
    echo "$cyan Target$red >$white ";
    $target = trim(fgets(STDIN));
    echo "$cyan Use Default List (Y/N)?$red  >$white ";
    $pilihan = trim(fgets(STDIN));
    if ($pilihan == 'Y' OR $pilihan == 'y'){
            $list = 'wordlist/subdo.txt';
        }
    else{
            echo "$cyan List$red >$white ";
            $list = trim(fgets(STDIN));
        }
    $targetnya = $target;
    echo "$yellow \n [!]==// Opening $list ...";
    $buka = fopen("$list","r");
    $ukuran = filesize("$list");
    $baca = fread($buka,$ukuran);
    $lists = explode("\r\n",$baca);
    echo "$cyan\n [!]==// Please Wait...
    ";
    foreach($lists as $subdo){
            $log = "$subdo.$targetnya";
            $ch = curl_init("$log");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($httpcode == 200){
                    $handle = fopen("result/subdo-$target.txt", "a+");
                    fwrite($handle, "$log\n");
                    print "\n$cyan  [".date('H:m:s')."]==//$white $log =>$cyan OK";
                }
            elseif($httpcode == 403){
                    print "\n$red  [".date('H:m:s')."]==//$white $log =>$red FORBIDDEN";
                }
            else{
                    print "\n$red  [".date('H:m:s')."]==//$white $log =>$red ERROR";
                }
        }
    echo "\n\n$cyan [!]==// Result OK reported to result/subdo-$target.txt\n\n $white ";
}

?>