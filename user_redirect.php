<?php

// URL = dominio.com/user_redirect_***.php?redirect_mkt_club=true
// VERSION 1.0

header('Content-type: application/json; charset=utf-8');

$privatyKey = "-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCk7RXHrHyy7f0E
em21IkK5V85Yv30yx4Q20N0taq07QvFMys0HClsucCaQ0Ztgt15BxzfjR2sbl4NC
w67jMvtGwaXI0HkqRRZGCfjPzvVs40hNsdY4Rx5zRhYgodVpm6g1gKOsRWifdo0j
BkKWm6ye2iEr2CHDxulw7K/xN++RXMiCvIU2QiDLDMPx9jyU3c+qcv878OFEMl7e
2lwWB+7US2Io/DO4gQtZJH8jUPK7cFBivfFZNLmpxMd9uNSuNq7R8pHjDeKaskM3
CXSWKIHaiOwAOavMRhDxiwsmVOYodktkIkwE09Mdg/IZ9xIM368ksC856U0l9e+E
ZNg16iJ5AgMBAAECggEBAJ4Te7+xbKgXgV6sdcCaQPfi2C2qBDcKkofzszrXt4hI
hn2DF/a6j2C4L864iMOvnZFQgBnAl0GP/EiexF6Ru9Q6wUrzvl6sb0fcQPX1OLkQ
M3n8jQXN7LqyH31Rf/rELfpx/O6ebEQDXg2G74XpWg+7pPWgJ+S9H3yT76M1aNKa
YMBlRhGqeN9dtuLeiE9i9WVQG50QyTgvw5TweHOoYsm/scSH4MVKfTcq7kYKjIwt
N/LLXzCnmF1Vnrs0glqL5po31DSkUdsLhtlHbxnzsHE8wweC+7G2DNyfOkZTaBqQ
gk59awpQgtOGMcOnSOBLIlUxdbMN1i4WgmV40BdFurECgYEA0aEvzsej7XF15e3I
biM7VEcdOG7gSo8dpwWRj2V+pPhdxmyE+/Lq/nYCLjFjm14B9j47CtgVUvvdgGZG
JBUVZulBEbxqGUVVlTZV+8Swo6iR2kFCu335XmiRbERqdCdrVrQwxQp9dfaVF0xV
IhZFmPEdmHE/EIVMzaBAA3lveC0CgYEAyWhygF8SbB8sYfLkqMqB1I3MnxCJVt6U
1t5I5VI26dtleUHDYPplFvvKPE2NZPdEtWRhcOHnSkLsNGTjj73YQ6yP8Qf2L6eO
9Hr/DcqAA2A6mT3ctUxr/p34szNSAU0qcomYMfHK/qupmnLDCDGQy9O6D212UIQh
MHs9nZtulv0CgYB9PI/kOE8N/tfRqtIwQmoiem3RliP3RzMO4nvIsHkNs7fKYHC+
WKzdosDAug7o9iuz4g/B9cAfmIsHN5K14casebO/FdJJEKwFfbW2uRZSX9XrD0v/
2U3OgihHB0SV6irtXK86OH8lp1AA4ECIIcgoi/wDY7yqcQimXBOCP91BbQKBgBTm
muNJem7v+Toc66+8fCajpHVpUOdL5+Q4YxYxJvOzyd8AfRcGRRFShdUmMyMkKeQt
C5OcTdU+BqcVRSw4hkXXlYRs0BZ36/ThArDar9gp10rpyYqi6J4epJ1sGPl7mYkT
UFD2h5tQEySs/iJOinkseqV5NYr7ezo9v9IoPBy9AoGBAMeRF1gVE5MyBpI71MAG
Oh4vzNQ0RK5NhzZuCVtVp2HqCWTOCHGFxJ2KPsVusXnHba2M/PKLZ4Y/KJA1MGEb
A+bbNtY34KOsVFMm8cGvr4B0m0cmxTONxT1KTiGdS67cC1xyJw5F+Tvqr95Tqc6F
UK3XKUohcVejhItaOnaY4EyJ
-----END PRIVATE KEY-----";


$DB['host'] = 'localhost';
$DB['db'] = 'API:WC2WP';
$DB['user'] = 'root';
$DB['passw'] = '';

require_once('index.php');
require_once('src/phpseclib1.0.20/Crypt/RSA.php');
require_once('src/phpseclib1.0.20/Math/BigInteger.php');

// INIT RSA
//* VERSION 1.0 */

    function ENCRIPT_RSA($string, $privateKey){
    $rsa = new Crypt_RSA();
    $rsa->loadKey($privateKey);
    $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    $encryptText = $rsa->encrypt($string);
    return $encryptText;
    }

// END RSA 


try{
$pdo = new PDO("mysql:host=".$DB['host'].";dbname=".$DB['db'].';charset=utf8;', $DB['user'], $DB['passw'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $error){
    echo "Ops Algo deu Errado \n tente novamente ! \n";
    echo $error->getMessage();
}


// INIT - GET INFO DB USER
//* Version 1.0 */
$id_user = preg_replace("/[^0-9]/", "", $current_user->ID);

$sql_11 = "SELECT * FROM wp_usermeta WHERE user_id = :user_id";
try{
    $read_11 = $pdo->prepare($sql_11);
    $read_11->bindValue(':user_id', $id_user, PDO::PARAM_STR);
    $read_11->execute();
} catch(PDOException $error){
    echo $error->getMessage();
}

$array = array();
while($rs_11 = $read_11->fetch(PDO::FETCH_OBJ)){
    $array[] = array($rs_11->meta_key => $rs_11->meta_value);
};

$get_data_cpf = array_column($array, 'cpf');
$get_data_data_nacimento = array_column($array, 'data_nacimento');
$get_data_telefone_pessoal = array_column($array, 'telefone_pessoal');
// END - GET INFO DB USER


// INIT DADOS DO USUARIO - GET IN WORDPRESS 

// INIT PREG_REPLACE 
// Version 1.0

function preg_replace_string($regras ,$replace, $string){
    return preg_replace($regras, $replace, $string);
}

// END PREG_REPLACE

// INIT DADOS DO USUARIO - GET IN WORDPRESS
// Version 1.0

echo "ID:"; print($id_user); echo "</br>";
echo "</br>CPF : ";
 $r_cpf =  array_shift(array_values($get_data_cpf)); 
print $r_cpf;
echo "</br>DATA NACIMENTO : ";
 $r_data_nasc = array_shift(array_values($get_data_data_nacimento)); 
print $r_data_nasc;
echo "</br>TELEFONE PESSOAL : ";
 $r_telefone_pessoal = array_shift(array_values($get_data_telefone_pessoal));
print $r_telefone_pessoal;

print "</br>";

echo "nome : ". ENCRIPT_RSA($r_cpf, $privatyKey);
echo "CPF : ". ENCRIPT_RSA($r_cpf, $privatyKey);
echo "data de nacimento : ". ENCRIPT_RSA($r_cpf, $privatyKey);
echo "CPF : ". ENCRIPT_RSA($r_cpf, $privatyKey);

echo "</br></br>USER LOGIN :"; print($current_user->user_login); echo "</br></br>";
echo "EMAIL PESSOAL :"; print($current_user->user_email); echo "</br></br>";
$email_user = $current_user->user_email;
echo "NOME :"; print($current_user->user_firstname); echo "</br></br>";
echo "SOBRENOME :"; print($current_user->user_lastname); echo "</br></br>";
echo "NOME COMPLETO:"; print($current_user->display_name); echo "</br></br>";
$name_user = $current_user->display_name;

// END DADOS DO USUARIO - GET IN WORDPRESS
  


if(@$_GET['redirect_mkt_club']):


// INIT - CREATE TOKEN

$_ARRAY_GET_TOKEN_HOMOLOC = array(
    'client_id' => '7653748280-qcQLTAvZ7Wv9Cu55f8g0WN2LgE8tyU80gk0ZMYiTkO1MEq99AxABrqFSUCT2qY$.benefit.com.br',
    'secret_id' => '57097-cyWjALAJgTxyapJmYSHXUngx1aO4m3bZKHanrA3J9AS9gHYrp6w1IvlsHDYyG1W', 
    'audience' => 'web', 
    'grant_type' => 'client_credentials', 
    'scope' => 'token_credential:salvar', 
);

$_ARRAY_GET_TOKEN_PRODUCTION = array(
    'client_id' => '6214368611-Cv3JmTuO9Xub7MeegFhwo%R14Nf9oJDz2TT2Z9E4e8fqp$BQsvJkP#wcUVGM%PfHqY3G2uYF%.benefit.com.br',
    'secret_id' => '14371-ILf8kOs3OJb4z9HmcBOG9mBjB5HTZr9Pce10OVQldOr2GwVr#3vlvMia4xQny5XL3KqthR#pH5', 
    'audience' => 'web', 
    'grant_type' => 'client_credentials', 
    'scope' => 'token_credential:salvar', 
);


    $curl_CREATETOKEN = curl_init();
curl_setopt_array($curl_CREATETOKEN, array(
           CURLOPT_URL => 'https://apiv4homologacao.marktclub.net.br/token',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS => $_ARRAY_GET_TOKEN_HOMOLOC,
       ));
$response_GET_TOKEN = curl_exec($curl_CREATETOKEN);
curl_close($curl_CREATETOKEN);

$return_GETTOKEN = json_decode($response_GET_TOKEN);

$return_string_token_status = '';
$return_string_token_token = '';
$return_string_token_scope = '';
$return_string_token_expires = '';
$return_string_token_token_type = '';

$return_string_token_erro_status = $return_GETTOKEN->status;
$return_string_token_erro_titulo = $return_GETTOKEN->erro->titulo;
$return_string_token_erro_mensagem = $return_GETTOKEN->erro->mensagem;
$return_string_token_erro_codigo = $return_GETTOKEN->erro->codigo;

if($return_string_token_status == "sucesso"):

$return_string_token_status .= $return_GETTOKEN->status;
$return_string_token_token .= $return_GETTOKEN->dado->access_token;
$return_string_token_scope .= $return_GETTOKEN->dado->scope;
$return_string_token_expires .= $return_GETTOKEN->dado->expires_in;
$return_string_token_token_type .= $return_GETTOKEN->token_type;

else:
    $return_string_token_erro_status = $return_GETTOKEN->status;
    $return_string_token_erro_titulo = $return_GETTOKEN->erro->titulo;
    $return_string_token_erro_mensagem = $return_GETTOKEN->erro->mensagem;
    $return_string_token_erro_codigo = $return_GETTOKEN->erro->codigo;    
    
    echo "TOKEN STATUS : "; print $return_string_token_erro_titulo; echo "<br>";
    echo "TOKEN Titulo : "; print $return_string_token_erro_titulo; echo "<br>";
    echo "TOKEN Mensagem : "; print $return_string_token_erro_mensagem; echo "<br>";
    echo "TOKEN Codigo : "; print $return_string_token_erro_codigo; echo "<br>";
endif;    

// END - CREATE TOKEN


// INIT REDIRECT FORM MKT CLUB
// Version 1.0 

$_ARRAY_GET_DATA_USER = array(
    'nome' => ENCRIPT_RSA($name_user, $privatyKey),
    'cpf' => ENCRIPT_RSA($r_cpf, $privatyKey),
    'data_nascimento' => ENCRIPT_RSA($r_data_nasc, $privatyKey),
    'email_pessoal' => ENCRIPT_RSA($email_user, $privatyKey),
    'telefone_pessoal' => ENCRIPT_RSA($r_telefone_pessoal, $privatyKey));   
// END REDIRECT FORM MKT CLUB


// INIT CURL - SEND IN MARKTCLUB 
// VERSION 1.0 
$curl = curl_init();
curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://apiv4homologacao.marktclub.net.br/login/api',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS => $_ARRAY_GET_DATA_USER,
           CURLOPT_HTTPHEADER => array(
               'Authorization: Bearer '.$return_string_token_token
           ),
       ));
$response = curl_exec($curl);
curl_close($curl);

//END CURL - SEND MARKCLUB

// RETURN DATA VIA JSON
// Version 1.0
$json_return = json_decode($response);

// DATA JSON 
$return_status = $json_return->status;
$return_link = $json_return->dado->link;
$return_titulo = $json_return->erro->titulo;
$return_mensagem = $json_return->erro->mensagem;
$return_codigo = $json_return->erro->codigo;
 

 if($return_status == "sucesso"):
    // REDIRECT DATA STATUS : sucesso
 echo "</br><hr></br>";   
 echo "STATUS : "; print $return_status; echo "<br>";
 echo "LINK : "; print $return_link; echo "<br>";
    ?>
    <script> location.href="<?php echo $return_link ?>"</script>
    <?php
 elseif($return_status == "erro"):
    //  REDIRECT DATA STATUS : erro
  echo "STATUS : "; print $return_status; echo "<br>";
 echo "Titulo : "; print $return_titulo; echo "<br>";
 echo "Mensagem : "; print $return_mensagem; echo "<br>";
 echo "Codigo : "; print $return_codigo; echo "<br>";
    ?>
    <script>alert('Usuario Invalido!')</script>
    <?php
 endif;

endif;


?>
