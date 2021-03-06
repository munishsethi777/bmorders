<?php
    require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
    require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Customer.php");
    require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
    require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
    require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
    require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");
    require_once($ConstantsArray['dbServerUrl'] ."Managers/UserCompanyMgr.php");
    class CustomerMgr{
        private static $customerMgr;
        private static $dataStore;
        private static $sessionUtil;
        
        public static function getInstance(){
            if (!self::$customerMgr){
                self::$customerMgr = new CustomerMgr();
                self::$dataStore = new BeanDataStore(Customer::$className, Customer::$tableName);
            }
            return self::$customerMgr;
        }
        
        public function findBySeq($seq){
            $customers = self::$dataStore->findBySeq($seq);
            return $customers;
        }
        public function findArrBySeq($seq){
        	$customers = self::$dataStore->findArrayBySeq($seq);
        	return $customers;
        }
        
        public function findAll($isApplyFilter = false){
            $sessionUtil =SessionUtil::getInstance();
            $isRep = $sessionUtil->isRepresentative();
            if($isRep){
                $userSeq = $sessionUtil->getUserLoggedInSeq();
                $query = "select customers.* from customers inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
                $customers = self::$dataStore->executeObjectQuery($query,$isApplyFilter);
                return $customers;
            }
            $customers = self::$dataStore->findAll($isApplyFilter);
            return $customers;
        }
        
        public function saveCustomer($customer){
            $id = self::$dataStore->save($customer);
            if(!empty($id) && empty($customer->getSeq())){
	            $sessionUtil = SessionUtil::getInstance();
	            $isRep = $sessionUtil->isRepresentative();
	            if($isRep){
	            	$userCompanyMgr = UserCompanyMgr::getInstance();
	            	$userCompanyMgr->saveFromUser($customer->getUserSeq(), array(0=>$id),false);
	           	}
            }
            return $id;
        }
        
        public function getAllCustomersForGrid(){
            $customers = $this->findAll(true);
            $mainArr = array();
            foreach ($customers as $customer){
                $arr["seq"] = $customer->getSeq();
                $arr["title"] = $customer->getTitle();
                $arr["contactperson"] = $customer->getContactPerson();
                $arr["mobile"] = $customer->getMobile();
                $arr["city"] = $customer->getCity();
                $arr["isenabled"] = !empty($customer->getIsEnabled());
                $arr["lastmodifiedon"] = $customer->getLastModifiedOn();
                array_push($mainArr, $arr);
            }
            $jsonArr["Rows"] =  $mainArr;
            $jsonArr["TotalRows"] = $this->getCount();
            return $jsonArr;
        }
        
        public function getCount(){
            $sessionUtil =SessionUtil::getInstance();
            $isRep = $sessionUtil->isRepresentative();
            $query = "select count(*) from customers";
            if($isRep){
                $userSeq = $sessionUtil->getUserLoggedInSeq();
                $query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
            }
            $count = self::$dataStore->executeCountQueryWithSql($query,true);
            return $count;
        }
        
        public function deleteBySeqs($ids) {
            $flag = self::$dataStore->deleteInList ( $ids );
            return $flag;
        }
        function _group_by($array, $key) {
            $return = array();
            foreach($array as $val) {
                $return[$val[$key]][] = $val;
            }
            return $return;
        }
        
        
        public function searchCustomers($searchString){
            $sessionUtil = SessionUtil::getInstance();
            $userType  = $sessionUtil->getUserLoggedInUserType();
            $userSeq = $sessionUtil->getUserLoggedInSeq();
            $sql = "select customers.* from customers";
            if($searchString != null){
                if($userType == UserType::getName(UserType::representative)){
                    $sql .= " inner join usercompanies on customers.seq = usercompanies.customerseq where (customers.title like '". $searchString ."%') and usercompanies.userseq = $userSeq";
                }else{
                    $sql .= " where (customers.title like '%". $searchString ."%')";
                }
            }
            
            $users =  self::$dataStore->executeQuery($sql);
            return $users;
        }
        
        public function getAllCustomerTitles(){
            $query = "select title,customers.seq from customers";
            $sessionUtil = SessionUtil::getInstance();
            $isRep = $sessionUtil->isRepresentative();
            if($isRep){
                $userSeq = $sessionUtil->getUserLoggedInSeq();
                $query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
            }
            $objs = self::$dataStore->executeQuery($query,false,true);
            $customers = array_map(create_function('$o', 'return $o["title"];'), $objs);
            return $customers;
        }
        
        private function getCustomers($isApplyFilter = false){
            $sessionUtil = SessionUtil::getInstance();
            $isRep = $sessionUtil->isRepresentative();
            $sql = "select customers.* from customers";
            if($isRep){
                $userSeq = $sessionUtil->getUserLoggedInSeq();
                $sql .= " inner join usercompanies on customers.seq = usercompanies.customerseq where (customers.title like '". $searchString ."%') and usercompanies.userseq = $userSeq";
            }
            $customers  = self::$dataStore->executeObjectQuery($sql,$isApplyFilter);
            return $customers;
        }
        
        public function exportCustomers($queryString){
            $output = array();
            parse_str($queryString, $output);
            $_GET = array_merge($_GET,$output);
            $customers =$this->getCustomers(true);
            ExportUtil::exportCustomers($customers);
        }
        
        function groupByCustomerSeq($array, $key) {
            $return = array();
            foreach($array as $val) {
                $return[$val[$key]] = $val["title"];
            }
            return $return;
        }
    
    }
