<?php


class UserController {

    static public function getUserByUsername($username){
        $response = UserModel::findUserByUsername($username);
        return $response;
    }

    static public function getUserById($id){
        $response = UserModel::findUserById($id);
        return $response;
    }

    static public function getMessageById($id){
        $response = UserModel::findMessageById($id);
        return $response;
    }

    static public function getFollowingsPosts($id){
        $response = UserModel::findFollowingsPostsById($id);
        return $response;
    }

    static public function saveUser($user){
        $response = UserModel::putUser($user);
        return $response;
    }

    static public function savePost($message){
        $response = UserModel::putMessage($message);
        return $response;
    }

    static public function getFollowingsById($id){
        $response = UserModel::findFollowingsById($id);
        return $response;
    }

    static public function getFollowersById($id){
        $response = UserModel::findFollowersById($id);
        return $response;
    }

    static public function getPostsById($id){
        $response = UserModel::findPostsById($id);
        return $response;
    }

    static public function followUserById($id_owner, $id_host){
        $response = UserModel::putFollowById($id_owner, $id_host);
        return $response;
    }

    static public function unfollowUserById($id_owner, $id_host){
        $response = UserModel::removeFollowById($id_owner, $id_host);
        return $response;
    }

    static public function searchUsersByCriteria($keyword){
        $keyword = '%'.$keyword.'%';
        $response = UserModel::findUsersByCriteria($keyword);
        return $response;
    }
}
?>