require('./bootstrap');


window.Echo.private('chat-message.' + window.Laravel.user)
    .listen('SendMessage', (data) => {
        console.log(data);

        $("#send").prop("disabled", false);
        $("#messages").append(`
                    <li class="mar-btm">
                    <div class="media-left">
                    <img src="` + data.message.user.profile_pic + `" class="img-circle img-sm" alt="Profile Picture"></div>
                    <div class="media-body pad-hor">
                    <div class="speech">
                    <a href="#" class="media-heading">` + data.message.user.name + `</a>
                    <p>` + data.message.message + `</p>
                    <p class="speech-time">
                    <i class="fa fa-clock-o fa-fw"></i>` + data.message.created_at + `
                    </p>
                    </div>
                    </div>
                    </li>
                `);
        $(".nano .nano-content").scrollTop(1E10);
    });
