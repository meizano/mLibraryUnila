<?php

# Use the Curl extension to query and get back a page of results
if($_GET){
    // Jika input type tidak ada, diberi nilai NULL
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : NULL;


    $url = "http://opac.unila.ac.id/ucs/index.php?search=Search&keywords=" . $keywords;
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

    $xpath = new DOMXPath($dom);
    // returns list
    // Informasi jumlah hasil pencarian dan waktu
    $info = $xpath->query("//div[@class='alert alert-info']");
    // daftar pustaka yang ditemukan
    $nlist = $xpath->query("//div[@class='item']");
    // Mendapatkan link halaman berikutnya
    $nextLink = $xpath->query("//div[@class='pagination pagingList']");

    // Mendapatkan nilai informasi hasil pencarian
    $infohasil = $info->item(0)->childNodes->item(1)->nodeValue . " " . $info->item(0)->childNodes->item(2)->nodeValue;
    
    // Mendapatkan nilai link halaman berikutnya
    $nLink = NULL;
    if($nextLink->item(0) != NULL)
        $nLink = 'http://opac.unila.ac.id/' . $nextLink->item(0)->childNodes->item(0)->childNodes->item(10)->childNodes->item(0)->attributes->item(0)->nodeValue;
    
    // Mencari link halaman lain
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(0)->childNodes->item(0)->attributes->item(0)->nodeValue;
////    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(1)->childNodes->item(0)->attributes->item(0)->nodeValue; //error
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(2)->childNodes->item(0)->attributes->item(0)->nodeValue; 
////    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(3)->childNodes->item(0)->attributes->item(0)->nodeValue; //error
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(4)->childNodes->item(0)->attributes->item(0)->nodeValue; 
////    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(5)->childNodes->item(0)->attributes->item(0)->nodeValue; //error
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(6)->childNodes->item(0)->attributes->item(0)->nodeValue;
////    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(7)->childNodes->item(0)->attributes->item(0)->nodeValue; //error
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(8)->childNodes->item(0)->attributes->item(0)->nodeValue;
////    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(9)->childNodes->item(0)->attributes->item(0)->nodeValue; //error
//    echo $nextLink->item(0)->childNodes->item(0)->childNodes->item(10)->childNodes->item(0)->attributes->item(0)->nodeValue;


    //foreach($nlist as $item) {
    //    echo $item->nodeName;
    //    echo $item->nodeValue;
    //    echo "\n" . "<br/>" ."\n";

    //    foreach($item->attributes as $ite) {
    //        echo $ite->nodeName;
    //    echo $ite->nodeValue;
    //    echo "\n" . "<br/>" ."\n";
    //    }

    //    foreach($item->childNodes as $ite) {
    //        foreach($ite->childNodes as $it) {
    //            echo $it->nodeName;
    //            if ($it->hasAttributes()) {
    //                foreach($it->attributes as $i) {
    //
    //                        echo $i->nodeName;
    //                        echo $i->nodeValue;
    //                }
    //            }
    //            echo $it->nodeValue;
    //            echo "\n" . "<br/>" ."\n";
    //        }
    //    }
    //
    //}

    //for ($i = $nlist->length; --$i >= 0; ) {
    //    $node = $nlist->item($i)->childNodes;
    //    for ($i = $node->length; --$i >= 0; ) {
    //        $nod = $node->item($i);
    //        echo $nod->nodeValue;
    //    }
    //
    //}


    # Menampilkan dalam html
    //$htmltext=$dom->saveHTML();
    //
    //echo $htmltext;

    /* JSON */
    $respon =  new stdClass();

    // Memberikan label
    $respon->label="opac.unila.ac.id/ucs";
    // Memasukkan informasi hasil pencarian ke dalam obyek $respon
    $respon->info=$infohasil;

    // Penampung nilai yang akan dimasukkan ke dalam obyek $respon
    $no = 0;
    $judul = '';
    $pengarang = '';
    $callNumber = '';
    $tersedia = '';
        $cantuman = '';

    foreach($nlist as $item) {

        foreach($item->childNodes as $ite) {
            foreach($ite->childNodes as $it) {
                if($it->nodeName == 'h4') {
                    $judul = $it->nodeValue;
                    continue;
                }
                // Agar tidak muncul warning https://stackoverflow.com/questions/2385834/php-dom-get-all-attributes-of-a-node
                if ($it->hasAttributes()) {
                    foreach($it->attributes as $i) {

                        if($i->nodeValue == 'subItem authorField') {
                            $pengarang = $it->nodeValue;
                        } else if($i->nodeValue == 'customField callNumberField') {
                            $callNumber = $it->nodeValue;
                        } else if($i->nodeValue == 'customField locationField') {
                            $tersedia = $it->nodeValue;
                        } else if($i->nodeValue == 'subItem') {
                            $cantuman = 'http://opac.unila.ac.id' . $it->childNodes->item(0)->attributes->item(0)->nodeValue;
//                            foreach($it->childNodes as $j) {
//                                if ($j->hasAttributes()) {
//                                    foreach($j->attributes as $k) {
//                                        if($k->nodeName == 'href') {
//                                            $cantuman = 'http://opac.unila.ac.id' . $k->nodeValue;
//                                        }
//                                    }
//                                }
//                            }
                        }
                    }
                }

            }
        }

        $respon->data[$no]=array($judul, $pengarang, $callNumber, $tersedia, $cantuman);//ambil yang perlu saja
        $no+=1;

    }

    // Menambahkan link ke halaman berikut
    $respon->nextLink=$nLink;

    echo json_encode($respon);
    /* JSON */
}
?>
