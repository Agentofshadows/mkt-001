<?php
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
