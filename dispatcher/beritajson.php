<?php

# Use the Curl extension to query and get back a page of results
if($_GET){
    // Jika input type tidak ada, diberi nilai NULL
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : NULL;


    $url = "https://meizanoam.wordpress.com/?search=Search&keywords=" . $keywords;
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
