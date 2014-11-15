Feature: Sentence Detection
  I need to be able to detect sentences from any given text

  Scenario: Detect simple sentence
    Given The following text:
      """
      Ini kalimat pertama. Ini kalimat kedua.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Ini kalimat pertama.
      Ini kalimat kedua.
      """

  Scenario: The first sentence begins with the first non whitespace character of the text
    Given The following text:
      """
           .Ini kalimat pertama. Ini kalimat kedua.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      .Ini kalimat pertama.
      Ini kalimat kedua.
      """
  Scenario: The first sentence begins with the first non whitespace character of the text #2
    Given The following text:
      """
           $Ini kalimat pertama. Ini kalimat kedua.
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      $Ini kalimat pertama.
      Ini kalimat kedua.
      """

  Scenario: The last sentence ends with the last non whitespace character of the text
    Given The following text:
      """
      Ini kalimat pertama. Ini kalimat kedua. Hehehe     
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Ini kalimat pertama.
      Ini kalimat kedua.
      Hehehe
      """

  Scenario: The sentence does not contain any sentence end characters
    Given The following text:
      """
        Ini kalimat pertama      
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Ini kalimat pertama
      """

  Scenario: The sentence does not contain any sentence end characters
    Given The following text:
      """
        Ini kalimat pertama.   Ini kalimat kedua.      
      """
    When I detect its sentences
    Then I should get the following sentences:
      """
      Ini kalimat pertama.
      Ini kalimat kedua.
      """

