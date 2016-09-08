<?php
/*******************************************************************************/
/*******************************   OPTIONS   **********************************/
/*******************************************************************************/

$app->add(function ($request, $response, $next) {
    $response = $response->withAddedHeader("Access-Control-Allow-Origin", "*")
            ->withAddedHeader("Access-Control-Allow-Headers", "content-type, accept, authorization")
            ->withAddedHeader("Access-Control-Allow-Credentials", "true")
            ->withAddedHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, DELETE");

    $response = $next($request, $response);
    return $response;
});

/*******************************************************************************/
/*******************************   GET   **************************************/
/*******************************************************************************/

$app->get('/categories', function ($request, $response, $args) {
    $list = Category::with('goods')->get()->toJson();
    $response->getBody()->write($list);
    
    return $response;
});

$app->get('/categories/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $list = Category::with('goods')->get()->find($id)->toJson();
    $response->getBody()->write($list);
    
    return $response;
});
$app->get('/purchases/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    if($id==='last'){
        $list = Purchase::with('purchaseItems')->get()->last()->toJson();
    }
    else{
        $list = Purchase::with('purchaseItems')->get()->find($id)->toJson();
    }   
    $response->getBody()->write($list);
    
    return $response;
});
$app->get('/purchases', function ($request, $response, $args) {
    $list = Purchase::all()->toJson();
    $response->getBody()->write($list);
    
    return $response;
});
$app->get('/purchases/good/{id}', function ($request, $response, $args) {
    $good_id=$args['id'];
    $list = PurchaseItem::with('purchase')->where('good_id',$good_id)->get()->toJson();
    $response->getBody()->write($list);
    
    return $response;
});
$app->get('/purchaseItems', function ($request, $response, $args) {
    $list = PurchaseItem::all()->toJson();
    $response->getBody()->write($list);
    
    return $response;
});
$app->get('/purchaseItems/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $list = PurchaseItem::find($id)->toJson();
    $response->getBody()->write($list);
    
    return $response;
});


/*******************************************************************************/
/*******************************   POST   **************************************/
/*******************************************************************************/

$app->post('/categories', function ($request, $response, $args) {
    $model = $request->getParsedBody();
    $category = Category::create($model);
    $response = $response->getBody()->write($category->toJson());
    
    return $response;
});
$app->post('/goods', function ($request, $response, $args) {
    $model = $request->getParsedBody();
    $good = Good::create($model);
    $response = $response->getBody()->write($good->toJson());
    
    return $response;
});
$app->post('/purchases', function ($request, $response, $args) {
    $model = $request->getParsedBody();
    $purchase= Purchase::create($model);
    $response = $response->getBody()->write($purchase->toJson());
    
    return $response;
});
$app->post('/purchaseItems', function ($request, $response, $args) {
    $model = $request->getParsedBody();
    $purchaseItem= PurchaseItem::create($model);
    $response = $response->getBody()->write($purchaseItem->toJson());
    
    return $response;
});

/*******************************************************************************/
/*******************************   PUT   **************************************/
/*******************************************************************************/

$app->put('/categories/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $updatesValue=$request->getParsedBody();
    $status = Category::find($id)->update($updatesValue);  
    $response=$status?Category::find($id)->toJson():json_encode(FALSE);
    
    return $response;
});
$app->put('/goods/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $updatesValue=$request->getParsedBody();
    $status = Good::find($id)->update($updatesValue);
    $response=$status?Good::find($id)->toJson():json_encode(FALSE);
    
    return $response;
});
$app->put('/purchaseItems/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $updatesValue=$request->getParsedBody();
    $status = PurchaseItem::find($id)->update($updatesValue);
    $response=$status?PurchaseItem::find($id)->toJson():json_encode(FALSE);
    
    return $response;
});
$app->put('/purchases/{id}', function ($request, $response, $args) {
    $id=$args['id'];
    $updatesValue=$request->getParsedBody();
    $status = Purchase::find($id)->update($updatesValue);
    $response=$status?Purchase::find($id)->toJson():json_encode(FALSE);
    
    return $response;
});
/*******************************************************************************/
/*******************************   DELETE   ***********************************/
/*******************************************************************************/

$app->delete('/categories/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $status = Category::destroy($id);
    $response = $response->getBody()->write(json_encode($status));
    
    return $response;
});
$app->delete('/goods/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $status = Good::destroy($id);
    $response = $response->getBody()->write(json_encode($status));
    
    return $response;
});
$app->delete('/purchases/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $status = Purchase::destroy($id);
    $response = $response->getBody()->write(json_encode($status));
    
    return $response;
});
$app->delete('/purchaseItems/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $status = PurchaseItem::destroy($id);
    $response = $response->getBody()->write(json_encode($status));
    
    return $response;
});

?>