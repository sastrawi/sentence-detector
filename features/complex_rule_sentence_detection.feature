Feature: Sentence Detection
  I need to be able to detect sentences from any given text

  Scenario: Detect simple sentence
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

