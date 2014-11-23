Sastrawi Sentence Detector
==========================

Sastrawi Sentence Detector adalah library PHP untuk melakukan deteksi kalimat.


| Development | Master | Releases | Statistics |
| ----------- | ------ | -------- | ---------- |
| [![Build Status](https://travis-ci.org/sastrawi/sentence-detector.svg?branch=development)](https://travis-ci.org/sastrawi/sentence-detector) [![Code Coverage](https://scrutinizer-ci.com/g/sastrawi/sentence-detector/badges/coverage.png?b=development)](https://scrutinizer-ci.com/g/sastrawi/sentence-detector/?branch=development) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sastrawi/sentence-detector/badges/quality-score.png?b=development)](https://scrutinizer-ci.com/g/sastrawi/sentence-detector/?branch=development) | [![Build Status](https://travis-ci.org/sastrawi/sentence-detector.svg?branch=master)](https://travis-ci.org/sastrawi/sentence-detector) | [![Latest Stable Version](https://poser.pugx.org/sastrawi/sentence-detector/v/stable.png)](https://packagist.org/packages/sastrawi/sentence-detector) | [![Total Downloads](https://poser.pugx.org/sastrawi/sentence-detector/downloads.png)](https://packagist.org/packages/sastrawi/sentence-detector) |


Sentence Detector
-----------------

Indonesia menempati posisi ke-4 negara berpenduduk terbanyak di dunia. Berdasarkan [sumber](http://www.thejakartapost.com/news/2013/06/18/facebook-has-64m-active-indonesian-users.html), pada 2013 tercatat Lebih dari 64 juta pengguna facebook berasal dari Indonesia.

Dalam aktivitas sehari-hari, pengguna internet di Indonesia menggunakan Bahasa Indonesia sebagai bahasa utama. Oleh sebab itu, para _developer_ mulai membutuhkan bantuan software untuk melakukan analisa text dalam Bahasa Indonesia. Salah satu tahap analisa tersebut adalah sentence detection atau sentence segmentation, yaitu memecah text menjadi kalimat-kalimat, contohnya:

    Saya sedang belajar NLP Bahasa Indonesia. Saya sedang melakukan segmentasi kalimat.

Text di atas terdiri dari 2 kalimat, yaitu:

    - Saya sedang belajar NLP Bahasa Indonesia.
    - Saya sedang melakukan segmentasi kalimat.

Masih terlihat sederhana, sampai muncul kalimat-kalimat berikut:

    Saya belajar NLP di Jl. Prof. Dr. Soepomo SH no. 11. Kapan saya harus ke sana?

Text di atas terdiri dari 2 kalimat, yaitu:

    - Saya belajar NLP di Jl. Prof. Dr. Soepomo SH no. 11.
    - Kapan saya harus ke sana?


Sastrawi Sentence Detector
--------------------------

- _Library PHP_ untuk melakukan _sentence segmentation_ pada Bahasa Indonesia.
- Mudah diintegrasikan dengan _framework_ / _package_ lainnya.
- Mempunyai _API_ yang sederhana dan mudah digunakan.
- Terinspirasi oleh Apache OpenNLP.


Demo
----
[http://sastrawi.github.io/sentence-detector.html](http://sastrawi.github.io/sentence-detector.html)


Cara Install
-------------

Sastrawi Sentence Detector dapat diinstall dengan [Composer](https://getcomposer.org).

1. Buka terminal (command line) dan arahkan ke directory project Anda.
2. [Download Composer](https://getcomposer.org/download/) sehingga file `composer.phar` berada di directory tersebut.
3. Tambahkan Sastrawi Sentence Detector ke file `composer.json` Anda :

```bash
php composer.phar require sastrawi/sentence-detector:~1
```

Jika Anda masih belum memahami bagaimana cara menggunakan Composer, silahkan baca [Getting Started with Composer](https://getcomposer.org/doc/00-intro.md).


Penggunaan
-----------

Copy kode berikut di directory project anda. Lalu jalankan file tersebut.

```php
<?php

// demo.php

// include composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// create sentence detector
$sentenceDetectorFactory = new \Sastrawi\SentenceDetector\SentenceDetectorFactory();
$sentenceDetector = $sentenceDetectorFactory->createSentenceDetector();

// detect sentence
$text = 'Saya belajar NLP Bahasa Indonesia. Saya sedang belajar melakukan segmentasi kalimat.';
$sentences = $sentenceDetector->detect($text);

foreach ($sentences as $i => $sentence) {
    echo "$i : $sentence<br />\n";
}

```

Lisensi
--------

Sastrawi Sentence Detector dirilis di bawah lisensi MIT License (MIT).
Library ini memuat daftar singkatan Bahasa Indonesia dengan lisensi [Creative Common BY SA](https://creativecommons.org/licenses/by-sa/3.0/deed.id) yang bersumber dari [http://id.wiktionary.org/wiki/Wiktionary:Daftar_singkatan_dan_akronim_bahasa_Indonesia](http://id.wiktionary.org/wiki/Wiktionary:Daftar_singkatan_dan_akronim_bahasa_Indonesia).


Informasi Lebih Lanjut
----------------------

- [FAQ](https://github.com/sastrawi/sentence-detector/wiki/FAQ)
- [Wiki](https://github.com/sastrawi/sentence-detector/wiki)
- [Roadmap](https://github.com/sastrawi/sentence-detector/issues/milestones)
- [Bug Report, Questions, Ideas](https://github.com/sastrawi/sentence-detector/issues)
