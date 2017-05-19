<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $guarded=[];//批量赋值黑名单
//	protected $fillable=[];//批量赋值白名单
	/**
	 * 递归实现无限制静态分类
	 * @param $data
	 * @param $pid
	 * @param $level
	 * @return array
	 */
	public function getTree($data,$pid=0,$level=0){
		static $arr=[];
		foreach ($data as $key=>$value){
			if($value->cate_pid==$pid) {
				$value['level']=$level;
				$arr[] = $value;
				$this->getTree($data,$value->cate_id,$level+1);
			}
		}
		return $arr;
	}
}

