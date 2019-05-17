<?php
    require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
    require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Supplier.php");
    require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
    require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
    require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
    require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");
    require_once($ConstantsArray['dbServerUrl'] ."Managers/UserCompanyMgr.php");
    class SupplierMgr{
        private static $supplierMgr;
        private static $dataStore;
        private static $sessionUtil;
        
        public static function getInstance(){
            if (!self::$supplierMgr){
                self::$supplierMgr = new SupplierMgr();
                self::$dataStore = new BeanDataStore(Supplier::$className, Supplier::$tableName);
            }
            return self::$supplierMgr;
        }
        
        public function findBySeq($seq){
            $suppliers = self::$dataStore->findBySeq($seq);
            return $suppliers;
        }
        public function findArrBySeq($seq){
        	$suppliers = self::$dataStore->findArrayBySeq($seq);
        	return $suppliers;
        }
        
        public function findAll($isApplyFilter = false){
            $suppliers = self::$dataStore->findAll($isApplyFilter);
            return $suppliers;
        }
        
        public function saveSupplier($supplier){
            $id = self::$dataStore->save($supplier);
            return $id;
        }
        
        public function getAllSuppliersForGrid(){
            $suppliers = $this->findAll(true);
            $mainArr = array();
            foreach ($suppliers as $supplier){
                $arr["seq"] = $supplier->getSeq();
                $arr["title"] = $supplier->getTitle();
                $arr["contactperson"] = $supplier->getContactPerson();
                $arr["mobile"] = $supplier->getMobile();
                $arr["city"] = $supplier->getCity();
                $arr["isenabled"] = !empty($supplier->getIsEnabled());
                $arr["lastmodifiedon"] = $supplier->getLastModifiedOn();
                array_push($mainArr, $arr);
            }
            $jsonArr["Rows"] =  $mainArr;
            $jsonArr["TotalRows"] = $this->getCount();
            return $jsonArr;
        }
        
        public function getCount(){
//             $sessionUtil =SessionUtil::getInstance();
//             $isRep = $sessionUtil->isRepresentative();
            $query = "select count(*) from suppliers";
//             if($isRep){
//                 $userSeq = $sessionUtil->getUserLoggedInSeq();
//                 $query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
//             }
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
        
        
        public function searchSuppliers($searchString){
            $sessionUtil = SessionUtil::getInstance();
            $userType  = $sessionUtil->getUserLoggedInUserType();
            $userSeq = $sessionUtil->getUserLoggedInSeq();
            $sql = "select suppliers.* from suppliers";
//             if($searchString != null){
//                 if($userType == UserType::getName(UserType::representative)){
//                     $sql .= " inner join usercompanies on customers.seq = usercompanies.customerseq where (customers.title like '". $searchString ."%') and usercompanies.userseq = $userSeq";
//                 }else{
                    $sql .= " where (suppliers.title like '%". $searchString ."%')";
//                 }
//             }
            
            $users =  self::$dataStore->executeQuery($sql);
            return $users;
        }
        
        public function getAllSuppliersTitles(){
            $query = "select title,seq from suppliers";
//             $sessionUtil = SessionUtil::getInstance();
//             $isRep = $sessionUtil->isRepresentative();
//             if($isRep){
//                 $userSeq = $sessionUtil->getUserLoggedInSeq();
//                 $query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
//             }
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
