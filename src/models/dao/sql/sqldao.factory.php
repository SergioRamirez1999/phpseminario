<?php

require_once ROOT_DIR."/models/dao/factory/dao.factory.php";
require_once ROOT_DIR."/models/dao/sql/user.imp.php";
require_once ROOT_DIR."/models/dao/sql/message.imp.php";
require_once ROOT_DIR."/models/dao/sql/following.imp.php";
require_once ROOT_DIR."/models/dao/sql/like.imp.php";

class SqlDaoFactory implements IDaoFactory {
    function createUserDao(){
        return new UserDaoImp();
    }

    function createMessageDao(){
        return new MessageDaoImp();
    }

    function createLikeDao(){
        return new LikeDaoImp();
    }

    function createFollowingDao(){
        return new FollowingDaoImp();
    }
}