let containerEl = document.querySelector('#follows-container');

let btnFollowers = document.querySelector('#btn-followers');
let btnFollowings = document.querySelector('#btn-followings');

let followingsExample = `
<div class="follows-layout-content fx">

    <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">

        <div class="box-icon-example"></div>

    </div>


    <div class="right-layout-content">


        <div class="top-content-post fx fx-jc-btw fx-ai-ctr">


            <div class="user-username-content fx fx-column">

                <div class="user-name">
                    <span>mrzFernando</span>
                </div>

                <div class="user-username">
                    <span>@fernandinho</span>
                </div>

            </div>

            <div class="btn btn-danger follows-button" >Dejar de seguir</div>


        </div>


    </div>

</div>`;

let followersExample = `
<div class="follows-layout-content fx">

    <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">

        <div class="box-icon-example"></div>

    </div>


    <div class="right-layout-content">


        <div class="top-content-post fx fx-jc-btw fx-ai-ctr">


            <div class="user-username-content fx fx-column">

                <div class="user-name">
                    <span>mrzFernando</span>
                </div>

                <div class="user-username">
                    <span>@fernandinho</span>
                </div>

            </div>

            <div class="btn btn-primary follows-button">Seguir</div>


        </div>


    </div>

</div>`;

window.addEventListener('load', () => {
    for(let i = 0; i < 3; i++)
        containerEl.innerHTML += followersExample;

    btnFollowers.addEventListener('click', () => {
        containerEl.innerHTML = "";
        btnFollowings.classList.remove("opt-selected")
        btnFollowers.classList.add("opt-selected")
        for(let i = 0; i < 3; i++)
            containerEl.innerHTML += followersExample;
    });
    
    btnFollowings.addEventListener('click', () => {
        containerEl.innerHTML = "";
        btnFollowers.classList.remove("opt-selected");
        btnFollowings.classList.add("opt-selected")
        for(let i = 0; i < 3; i++)
            containerEl.innerHTML += followingsExample;
    });
});
