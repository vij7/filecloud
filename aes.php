<?php
	/*
		Version: 1.0
	*/
	class aes_encryption{
		
		const CIPHER = MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
		const MODE   = MCRYPT_MODE_CBC;
		
		public $key; // needs to be 32 bytes for aes
		public $iv; // needs to be 16 bytes for aes

		public function __construct($key = '', $iv = ''){
			$this->key = $key;
			$this->iv = $iv;
		}

		function rand_key($length = 32){
			$key = openssl_random_pseudo_bytes($length);
			return $key;
		}

		function rand_iv(){
			$ivSize = mcrypt_get_iv_size(self::CIPHER, self::MODE);
			$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
			return $iv;
		}

		public function encrypt($plaintext){			
			$ciphertext = mcrypt_encrypt(self::CIPHER, $this->key, $plaintext, self::MODE, $this->iv);
			return base64_encode($ciphertext);
		}

		public function decrypt($ciphertext){
			$ciphertext = base64_decode($ciphertext);
			$plaintext = mcrypt_decrypt(self::CIPHER, $this->key, $ciphertext, self::MODE, $this->iv);
			return rtrim($plaintext, "\0");
		}

		public function encrypt_file($input_file, $output_file){
			$input_file_handle = @fopen($input_file, "r");
			$output_file_handle = @fopen($output_file, 'wb');

			if(!$input_file_handle){ throw new Exception("Could not open input file"); }
			if(!$output_file_handle){ throw new Exception("Could not open output file"); }

			while(!feof($input_file_handle)){
				$buffer = base64_encode(fread($input_file_handle, 4096));		  			  
				$encrypted_string = $this->encrypt($buffer);
				// echo strlen($encrypted_string).'<br>';
				fwrite($output_file_handle, $encrypted_string);
				
			}
			fclose($input_file_handle);
			fclose($output_file_handle);
			
			return true;
			
		}

		public function decrypt_file($input_file, $output_file){
			$input_file_handle = @fopen($input_file, "r");
			$output_file_handle = @fopen($output_file, 'wb');

			if(!$input_file_handle){ throw new Exception("Could not open input file"); }
			if(!$output_file_handle){ throw new Exception("Could not open output file"); }

			while(!feof($input_file_handle)){
				//4096 bytes plaintext become 7296 bytes of encrypted base64 text
				$buffer = fread($input_file_handle, 7296);
				$decrypted_string = base64_decode($this->decrypt($buffer));
				// echo strlen($buffer).'<br>';
				fwrite($output_file_handle, $decrypted_string);
			}

			fclose($input_file_handle);
			fclose($output_file_handle);

			return true;
		}


	}//class aes_encryption


// 	php-aes-class
// =============

// A PHP class to handle aes text and file encryption.

// I wasn't able to find a satisfacty write up or class for handling both text and file encryption/decryption using aes, so I wrote my own. 

// Text encryption is easy, and can be accomplished with a user provided key and iv, or by creating random ones. Be sure to save the random ones somewhere, as neither are saved by default (the iv is not added to the ciphertext).

//     include('aes.php');
    
//     $crypt = new aes_encryption();
    
//     $crypt->key = $crypt->rand_key();
//     $crypt->iv = $crypt->rand_iv();
    
//     // or to provide a passphrase and your own iv, you could do something like the
//     // following, though there are certainly better ways, this works well enough
//     // for testing purposes. 
    
//     // $passphrase = 'ThisIsMyPassphrase';
//     // $iv = substr(md5('YourIV'.$passphrase, true), 0, 16);
//     // $key = md5($passphrase, true);
	  
//     // You would pass the below when initializing the class like:
//     // $crypt = new aes_encryption($key, $iv);
  
//     // we base64_encode() the plain text before encryption to ensure that the 
//     // plaintext length's byte size is a multiple of 16.
//     $encrypted_string = $crypt->encrypt(base64_encode('this is a test'));
//     echo $encrypted_string.'<br>';

//     $decrypted_string = base64_decode($crypt->decrypt($encrypted_string));
//     echo $decrypted_string.'<br>';
    
// File encryption is similarly easy. This method encrypts files in chunks of 4096 bytes to allow php to process large files without needing to load the entire file into memory at once.

//     include('aes.php');
    
//     $crypt = new aes_encryption();
    
//     $crypt->key = $crypt->rand_key();
//     $crypt->iv = $crypt->rand_iv();
    
//     $file = 'path/to/file/file.txt';
    
//     $crypt->encrypt_file($file, $file.'.enc');
    
//     $crypt->decrypt_file($file.'.enc', $file);

// This is just my inital set up, and it could probably use some tweaks (specifically with the file encryption and the base64 handling, which is producing encrypted files about 66% larger than the original. I'd like to cut that down but will need to test out whether I can pull one of the base64 steps without messing up the sizing of the chunks that I'm using. I also need to do more testing to ensure that removing the \0 btyes with trim will not cause any edge case issues with any files, so far none of my tests on files has failed.).

