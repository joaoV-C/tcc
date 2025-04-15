<?php
class CheckoutErrorHandler {

  public function isInputEmpty(string $country, string $fullName, string $phoneNumber, string $address, string $city, string $district, string $postalCode): bool {
    return empty($country) || empty($fullName) || empty($phoneNumber) || empty($address)
      || empty($city) || empty($district) || empty($postalCode);
  }
}
