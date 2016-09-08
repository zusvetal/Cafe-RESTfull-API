<?php
$app->get('/', function ($request, $response, $args) {
        include 'app/views/home.html';
        return $response;
});

$app->get('/hello', function ($request, $response, $args) {
    return $this->view->render($response, 'good_list.html');
})->setName('good_list');

$app->get('/test', function ($request, $response, $args) {
    echo '<pre>';
    print_r($this->view);
    echo '</pre>';
    return $response;
});
?>