<?php

class Good extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = array('id');
    public $timestamps = false;

    public function category() {
        return $this->belongsTo('Category');
    }

}

class Category extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = array('id');
    public $timestamps = false;

    public function goods() {
        return $this->hasMany('Good');
    }

}

class Purchase extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = array('id');
    public $timestamps = false;

    public function purchaseItems() {
        return $this->hasMany('PurchaseItem');
    }

}

class PurchaseItem extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = array('id');
    public $timestamps = false;

//    protected $table = 'purchase_list';

    public function purchase() {
        return $this->belongsTo('Purchase');
    }

    public function good() {
        return $this->belongsTo('Good');
    }

}
class Auth extends \Illuminate\Database\Eloquent\Model {

    protected $guarded = array('id');
    public $timestamps = false;
    protected $table='auth';

}

?>
