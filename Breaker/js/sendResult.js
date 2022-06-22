import { finalScore, pseudo } from './app.js' // on recupere le score de la partie jouer et le pseudo

$('.send_score').submit(function (e) {
    e.preventDefault();
    let postdata = $('.send_score').serialize();
    $.ajax({
        type: "GET",
        url: './controler/resultControler.php',
        data: postdata,
        dataType: 'json',
        success: function () {
            $.get("./controler/resultControler.php?score=" + finalScore + "&pseudo=" + pseudo, function (json) {
                $(alert('Score envoyé'));
            });
            $(".box-leaderboard").load(window.location + " .box-leaderboard");
            $(".own-message").load(window.location + " .own-message");
            $(".global-message").load(window.location + " .global-message");
            $('#buttonSend').prop("disabled", true)
        }
    })
})





