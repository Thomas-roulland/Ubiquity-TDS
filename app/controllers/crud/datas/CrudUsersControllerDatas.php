<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;
 /**
  * Class CrudUsersControllerDatas
  */
class CrudUsersControllerDatas extends CRUDDatas{
	//use override/implement Methods
    public function getFieldNames($model)
    {
        return ['firstname','lastname', 'email'];
    }

}

