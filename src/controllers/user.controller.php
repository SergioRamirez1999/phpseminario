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

    static public function getFollowingsPosts($id, $origin=0, $rows=10){
        $response = UserModel::findFollowingsPostsById($id, $origin, $rows);
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

    static public function getPostsById($id, $origin=0, $rows=10){
        $response = UserModel::findPostsById($id, $origin, $rows);
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

    static public function removePostById($id){
        $response = UserModel::deletePostById($id);
        return $response;
    }

    static public function editUserById($id, $field, $value){
        $response = UserModel::updateUserById($id, $field, $value);
        return $response;
    }

    static public function editUserImage($id, $image_content, $image_type){
        $response = UserModel::uploadUserImage($id, $image_content, $image_type);
        return $response;
    }

    static public function getLikesByPostId($id){
        $response = UserModel::findLikesByPostId($id);
        return $response;
    }

    static public function saveLike($id_user, $id_post){
        $response = UserModel::putLike($id_user, $id_post);
        return $response;
    }

    static public function removeLike($id_user, $id_post){
        $response = UserModel::deleteLike($id_user, $id_post);
        return $response;
    }

    static public function removeAllLikes($id_post){
        $response = UserModel::deleteAllLikes($id_post);
        return $response;
    }
}
?>