import {
    sendAjaxRequest
} from './modal-helper.js';
const btnFollowUser = document.querySelector("#btn-follow-user");

if(btnFollowUser != undefined){

    let isFollowing = btnFollowUser.getAttribute("following");

    const userId = document.querySelector("#user_id").value;
    const userIdToFollowUnfollow = document.querySelector("#follow_user_id").value;


    function buttonStyleFollow(){
        btnFollowUser.style = "background-color: #d21c38;margin-top: 8px;";
        btnFollowUser.innerText = 'Dejar de seguir';
    }

    function buttonStyleUnfollow(){
        btnFollowUser.style = "background-color: #00acee;margin-top: 8px;";
        btnFollowUser.innerText = 'Siguiendo';
    }

    function buttonStyle(){

        if(isFollowing == "true"){
            btnFollowUser.addEventListener('mouseover', buttonStyleFollow);
            btnFollowUser.addEventListener('mouseout', buttonStyleUnfollow);
        }else {
            btnFollowUser.removeEventListener('mouseover', buttonStyleFollow);
            btnFollowUser.removeEventListener('mouseout', buttonStyleUnfollow);
            btnFollowUser.style = "background-color: #00acee;margin-top: 8px;";
            btnFollowUser.innerText = 'Seguir';
        }
    }

    buttonStyle();

    btnFollowUser.addEventListener('click', () => {

        let fdata = new FormData();
        fdata.append('user_id', userId);
        fdata.append('user_id_fu', userIdToFollowUnfollow);
        fdata.append('is_following', isFollowing);
        sendAjaxRequest('controllers/ajax/followunfollow.controller.php', 'POST', fdata, (response) => {
            if(response.status == 200){
                if(response.body == "follow"){
                    btnFollowUser.innerText = 'Siguiendo';
                    isFollowing = "true";
                    let followers = document.querySelector("#span_followers").innerText;
                    followers = parseInt(followers.split(' ')[0])+1 + ' seguidores';
                    document.querySelector("#span_followers").innerText = followers;

                }else if(response.body == "unfollow"){
                    btnFollowUser.innerText = 'Seguir';
                    isFollowing = "false";

                    let followers = document.querySelector("#span_followers").innerText;
                    followers = parseInt(followers.split(' ')[0])-1 + ' seguidores';
                    document.querySelector("#span_followers").innerText = followers;
                }
                buttonStyle();
            }
        });
        
    });


}
