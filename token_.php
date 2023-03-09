<?php
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

?>
