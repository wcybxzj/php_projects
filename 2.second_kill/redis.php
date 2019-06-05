<?php
class my_redis{
	//1.私有的静态属性

	protected $host="127.0.0.1";
	protected $port;
	protected $user;
	protected $pwd;
	protected $max;
	protected $key;

	private static $instance = NULL;
	private static $redis = NULL;

	//2.私有的构造方法
	private function __construct(){
		self::$redis = new Redis();
		$ret = self::$redis->connect('127.0.0.1', 6379);
		if(!$ret){
			self::$redis=NULL;
		}
		if ($this->host!='127.0.0.1') {
			if (self::$redis) {
				if (!self::$redis->auth($this->user.":".$this->pwd)) {
					self::$redis=NULL;
				}
			}
		}
	}

	//3.私有的克隆方法
	private function __clone() {
		//
	}

	//1.公有的静态方法
	public static function getIntance() {
		if(self::$instance==false){
			self::$instance=new self;
		}
		if(isset(self::$redis)){
			return self::$instance;
		}else{
			return NULL;
		}
	}

	public function sIsMember($zset_key, $member) {
		return self::$redis->sIsMember($zset_key, $member);
	}

	public function sAdd($zset_key, $member) {
		return self::$redis->sAdd($zset_key , $member);
	}

	public function close() {
		if(isset(self::$redis)){
			self::$redis->close();
			self::$redis = NULL;
			return TRUE;
		}
		return FALSE;
	}

	public function flushDB()
	{
		self::$redis->flushDB();
	}
}
