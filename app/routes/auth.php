<?php
use Firebase\JWT\JWT;

$container['jwt'] = function ($container) {
    return new StdClass;
};

//$app->add(new \Slim\Middleware\JwtAuthentication([
//    'secure'=>false,
//    'path'=>['/'],
//    'passthrough' => ['/login', '/logout'],
//    'secret' =>'1234',
//    'callback' => function ($request, $response, $arguments) use ($container) {
//        $container['jwt'] = $arguments['decoded'];
//    }
//]));


$app->post('/login', function ($request, $response, $args) use ($container) {
    $options=$request->getParsedBody();
    $username=$options['username'];
    $password=$options['password'];
    $auth = Auth::where('username', $username)->get()->toArray();
    if (!empty($auth)) {
        $hash = $auth[0]['hash'];
        $id = $auth[0]['id'];
        if (password_verify($password, $hash)) {
            $token_options = array(
                'username' => $username,
                'id' => $id
            );
            $token=JWT::encode($token_options, '1234');
            return $response->getBody()->write(json_encode(array('token'=>$token)));
        }
    }

    return $response->withStatus(401);
});
$app->post('/logout', function ($request, $response, $args) use ($container) {
    print_r($container['jwt']->username);
    return $response;
});


//    password_hash($password, PASSWORD_DEFAULT);
//    password_verify ($password,$hash );
//    print_r($container['jwt']->username);
    
//    $token['username']='vetal';
//    $tok=JWT::encode($token, '1234');
//    print_r($tok);
//    print_r(JWT::decode($tok,'1234',array('HS256')));
?>

