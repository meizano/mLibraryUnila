<?php

# Use the Curl extension to query and get back a page of results
if($_GET){

//    $url = "library_unila.html" ;
    $url = "http://library.unila.ac.id/web/";
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $html = curl_exec($ch);
    curl_close($ch);

    # Create a DOM parser object
    $dom = new DOMDocument();

    # Parse the HTML.
    # The @ before the method call suppresses any warnings that
    # loadHTML might throw because of invalid HTML in the page.
    @$dom->loadHTML($html);
    print_r($dom->saveHTML());
    $xpath = new DOMXPath($dom);
    // returns list
    // berita yang ditampilkan
    $nlist = $xpath->query("//article");
    echo $nlist->asXML();

    /* JSON */
    $respon =  new stdClass();

    // Memberikan label
    $respon->label="library.unila.ac.id/web";
    $respon->article = $nlist;
    
    // Penampung nilai yang akan dimasukkan ke dalam obyek $respon
//    $no = 0;
//    $judul = '';
//    $waktu = '';
//    $penulis = '';
//    $berita = '';
//
//    foreach($nlist as $article) {
//
//        foreach($article->childNodes as $articl) {
//            foreach($articl->childNodes as $artic) {
//                if($artic->nodeName == 'h2') {
//                    $judul = $artic->nodeValue;
//                    continue;
//                }
//                // Agar tidak muncul warning https://stackoverflow.com/questions/2385834/php-dom-get-all-attributes-of-a-node
//                if ($artic->hasAttributes()) {
//                    foreach($artic->attributes as $arti) {
//
//                        if($arti->nodeValue == 'time') {
//                            $waktu = $artic->nodeValue;
//                        } else if($arti->nodeValue == 'a') {
//                            $penulis = $artic->nodeValue;
//                        } else if($arti->nodeValue == 'entry-content') {
//                            $berita = 'http://library.unila.ac.id/web' . $artic->childNodes->article(0)->attributes->article(0)->nodeValue;
//                        }
//                    }
//                }
//
//            }
//        }
//
//        $respon->data[$no]=array($judul, $waktu, $penulis, $berita);//ambil yang perlu saja
//        $no+=1;
//        
//    }
//
//    // Menambahkan link ke halaman berikut
//    $respon->nextLink=$nLink;

    echo json_encode($respon);
    /* JSON */
}
?>
