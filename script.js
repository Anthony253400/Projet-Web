$(document).ready(function(){

    function afficher(){
        $.ajax({
            url: 'afficher_messages.php',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    let html = '';
                    res.messages.forEach(msg => {
                        html += `<p><strong>${msg.client}:</strong> ${msg.contenu}</p>`;
                    });
                    $("#chat").html(html);
                }
            }
        });
    }

    afficher(); 
    setInterval(afficher, 1000);

    setTimeout(function() {
        $(".bloc-chat").fadeIn();
    }, 1000);

    let chatOuvert = true;
    $("#titre").click(function() {
        if(chatOuvert) {
            $("#chat-bas").slideUp(300);
            $(".bloc-chat").animate({height: "50px"}, 300);
        } else {
            $(".bloc-chat").animate({height: "300px"}, 300, function() {
                $("#chat-bas").slideDown(300);
            });
        }
        chatOuvert = !chatOuvert;
    });

    
    $("#form-message").on("submit", function(e) {
        e.preventDefault();
        let message = $("#message").val(); 


        $.ajax({
            url: "ia/valid.php",
            type: "POST",
            dataType: "json",
            data: { message: message },
            success: function(validRes) {
                if(validRes.success){
                    $.ajax({
                        url: "enregistrer_mess.php",
                        type: "POST",
                        dataType: "json",
                        data: { message: message },
                        success: function(saveRes){
                            if(saveRes.success){
                                $("#err").text("");
                                $('#envoyer').css("background-color", "green");
                                setTimeout(function() {
                                    $('#envoyer').css("background-color", '#007bff');
                                }, 500);
                                $("#form-message")[0].reset();
                            } else {
                                $("#err").text(saveRes.message);
                            }
                        },
                        error: function(){
                            $("#err").css("color","red").text("Erreur enregistrement message");
                        }
                    });
                } else {
                    $("#err").text(validRes.message);
                }
            },
            error: function(){
                $("#err").css("color","red").text("Erreur validation message");
            }
        });
    });
});
