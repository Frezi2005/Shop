<?php

App::uses("Component", "Controller");

class PasswordHashingComponent extends Component {
    public function encrypt($password) {
        $cipher = "AES-256-CBC";
        $iv = hash("ADLER32", $cipher).hash("CRC32B", $cipher);
        $ciphertext = openssl_encrypt($password, $cipher, hash("SHA512", $cipher), OPENSSL_RAW_DATA, $iv);

        return hash("WHIRLPOOL", base64_encode($ciphertext));
    }
}