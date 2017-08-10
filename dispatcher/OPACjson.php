<?php

# Use the Curl extension to query and get back a page of results
if($_GET){
    // Jika input type tidak ada, diberi nilai NULL
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : NULL;


    $url = "http://opac.unila.ac.id/index.php?search=search&keywords=" . $keywords;
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
    $info = $xpath->query("//div[@class='info']");
    $nlist = $xpath->query("//div[@class='item']");
    $nextLink = $xpath->query("//a[@class='next_link']");

    $infohasil = $info->item(0)->nodeValue;

    $nLink = 'http://opac.unila.ac.id' . $nextLink->item(0)->attributes->item(0)->nodeValue;


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

    $respon->label="OPAC.unila.ac.id";
    $respon->info=$infohasil;


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

                        if($i->nodeValue == 'author') {
                            $pengarang = $it->nodeValue;
                        } else if($i->nodeValue == 'customField callNumberField') {
                            $callNumber = $it->nodeValue;
                        } else if($i->nodeValue == 'customField availabilityField') {
                            $tersedia = $it->nodeValue;
                        } else if($i->nodeValue == 'subItem') {
                            foreach($it->childNodes as $j) {
                                if ($j->hasAttributes()) {
                                    foreach($j->attributes as $k) {
                                        if($k->nodeName == 'href') {
                                            $cantuman = 'http://opac.unila.ac.id' . $k->nodeValue;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }

        $respon->data[$no]=array($judul, $pengarang, $callNumber, $tersedia, $cantuman);//ambil yang perlu saja
        $no+=1;

    }

    $respon->nextLink=$nLink;

    echo json_encode($respon);
    /* JSON */
}
?>
