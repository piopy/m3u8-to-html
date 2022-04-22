
<?php
    // piopy [https://github.com/piopy] github -> m3u8 to html converter

    // example: url=https://iptv-org.github.io/iptv/countries/it.m3u
    if(isset($_GET['url']) && $_GET['url']!=''){
        $url=$_GET['url'];
    }else{
        die();
    }

    if(str_contains($url,"/Free-TV/IPTV/")){        //https://github.com/Free-TV/IPTV/
        $mode="FREE-IPTV";
    }else $mode="iptv-org";                         //https://github.com/iptv-org/iptv

    $text=file_get_contents($url);

    if($mode=="iptv-org"){
        
        foreach(file($url) as $line){
            if(str_starts_with($line,'http')) $links[]=$line;
        }
        
        $regex_names='/(?<=",).*/';
        preg_match_all($regex_names,$text,$names);
        $names=$names[0];
        $regex_imgs='/(?<=tvg-logo=").*(?=" g)/';     // someone is null
        preg_match_all($regex_imgs,$text,$imgs);
        $imgs=$imgs[0];


        for($i=0;$i<count($links);$i++){   // just print an <a href=ch-link title=ch-name><img src=ch-logo> ch-name </a> 
            
            if($imgs[$i]=='')echo ' <a href="'.trim($links[$i]).'" title="'.$names[$i].'" class="btn btn-outline-info" target="_blank">'.$names[$i].'</a>';//<br> ';
            else echo ' <a href="'.trim($links[$i]).'" title="'.$names[$i].'" class="btn btn-outline-info" target="_blank"><img src='.$imgs[$i].'  style="height: 20px !important;">'.$names[$i].'</a>';//<br> ';
            
        }

    }else{
        $regex_links='/(?<=\[>\]\().+(?=\))/';
        preg_match_all($regex_links,$text,$links);
        $links=$links[0];
        $regex_names='/(?<=\|).+(?=\| *\[>\])/';
        preg_match_all($regex_names,$text,$names);
        $names=$names[0];
        $regex_imgs='/(?<=<img height="20" src=").+(?=")/';
        preg_match_all($regex_imgs,$text,$imgs);
        $imgs=$imgs[0];

        for($i=0;$i<count($links);$i++){ // just print an <a href=ch-link title=ch-name><img src=ch-logo> ch-name </a> 
            echo ' <a href="'.trim($links[$i]).'" title="'.$names[$i].'" class="btn btn-outline-info" target="_blank"><img src='.$imgs[$i].'  style="height: 20px !important;">'.$names[$i].'</a>';//<br> ';
            }

    }
?>