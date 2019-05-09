<?php

# Use the Curl extension to query and get back a page of results
if($_GET){
    # Jika input type tidak ada, diberi nilai NULL
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : NULL;

    # Mengambil HTML
    // $url = "http://opac.unila.ac.id/index.php?search=search&keywords=" . $keywords;
    $url = "http://localhost/git/mLibraryUnila/dispatcher/OPACjamur.html";
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
    # Mencetak HTML
    // print_r($dom->saveHTML());

    # Create DOMXPath Object and load DOMDocument Object into XPath for magical goodness
    $xpath = new DOMXPath($dom);

    # returns list
    # Mencari nilai berdasarkan persyaratan kondisi query
    # Informasi jumlah hasil pencarian
    $infoJumlah = $xpath->query("//div[@class='search-found-info']");
    $infoJumlahValue = $infoJumlah->item(0)->nodeValue;
    // echo $infoJumlahValue;
    # Informasi kata kunci pencarian
    $infoKataKunci = $xpath->query("//span[@class='search-keyword-info']");
    $infoKataKunciValue = $infoKataKunci->item(0)->nodeValue;
    // echo $infoKataKunciValue;
    # Informasi kata kunci pencarian
    $infoWaktu = $xpath->query("//div[@class='search-query-time']");
    $infoWaktuValue = $infoWaktu->item(0)->nodeValue;
    // echo $infoWaktuValue;

    # daftar pustaka yang ditemukan
    $nlist = $xpath->query("//div[@class='item']");
    
    # Mendapatkan link halaman berikutnya
    $nextLink = $xpath->query("//a[@class='next_link']");

        // Mendapatkan nilai link halaman berikutnya
    $nLink = NULL;
    if($nextLink->item(0) != NULL)
        $nLink = 'http://opac.unila.ac.id' . $nextLink->item(0)->attributes->item(0)->nodeValue;

    /* JSON */
    $respon =  new stdClass();

    // Memberikan label
    $respon->label="OPAC.unila.ac.id";
    // Memasukkan informasi hasil pencarian ke dalam obyek $respon
    $respon->info=$infoJumlahValue;

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

                        if($i->nodeValue == 'author') {
                            $pengarang = $it->nodeValue;
                        } else if($i->nodeValue == 'customField callNumberField') {
                            $callNumber = $it->nodeValue;
                        } else if($i->nodeValue == 'customField availabilityField') {
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
