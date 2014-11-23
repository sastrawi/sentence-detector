Feature: Sentence Detection
  I need to be able to detect sentences from any given text

  Scenario: Detect simple abbreviation
    Given The following text:
      """
      Budi pergi ke Jl. KH. Mukmin no. 67. Dia tersesat.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi pergi ke Jl. KH. Mukmin no. 67.
      Dia tersesat.
      """

  Scenario: Detect complex abbreviation
    Given The following text:
      """
      Budi mengirim uang ke rekening a.n. Budi. Uang tersebut adalah biaya kursus NLP Bahasa Indonesia.
      Budi sedang mencari kepanjangan dari a.m.v.b. yang membingungkan.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi mengirim uang ke rekening a.n. Budi.
      Uang tersebut adalah biaya kursus NLP Bahasa Indonesia.
      Budi sedang mencari kepanjangan dari a.m.v.b. yang membingungkan.
      """

  Scenario: Detect thousand separator and money format
    Given The following text:
      """
      Budi mengambil uang sejumlah Rp. 2.375.000. Uang tersebut untuk belajar NLP Bahasa Indonesia.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi mengambil uang sejumlah Rp. 2.375.000.
      Uang tersebut untuk belajar NLP Bahasa Indonesia.
      """

  Scenario: Detect quote
    Given The following text:
      """
      Budi berkata, "Baiklah, saya akan belajar NLP Bahasa Indonesia. Saya akan mulai dari segmentasi kalimat." Lalu Budi mulai lelah.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi berkata, "Baiklah, saya akan belajar NLP Bahasa Indonesia.
      Saya akan mulai dari segmentasi kalimat."
      Lalu Budi mulai lelah.
      """

  Scenario: Detect email address
    Given The following text:
      """
      Budi mengirim email ke andy.librian@gmail.com. Dia senang sekali.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi mengirim email ke andy.librian@gmail.com.
      Dia senang sekali.
      """

  Scenario: Detect email address 2
    Given The following text:
      """
      Dia dipanggil untuk interview. Dia mengirim email ke andylibrian@gmail.com.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Dia dipanggil untuk interview.
      Dia mengirim email ke andylibrian@gmail.com.
      """

  Scenario: Detect email address 3
    Given The following text:
      """
      a@gmail.com adalah email yang aneh. Siapa yang membuat email seperti itu?
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      a@gmail.com adalah email yang aneh.
      Siapa yang membuat email seperti itu?
      """
  
  Scenario: Detect top level domain
    Given The following text:
      """
      Budi mengakses sastrawi.github.io. Dia menemukan halaman demo.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi mengakses sastrawi.github.io.
      Dia menemukan halaman demo.
      """

  Scenario: Detect top level domain 2
    Given The following text:
      """
      Budi mengakses github.com/sentence-detector. Dia menemukan repository.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Budi mengakses github.com/sentence-detector.
      Dia menemukan repository.
      """

