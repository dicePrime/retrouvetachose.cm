$(document).ready(function ()
{
    //$("#btnSubmit").bind('click', submitContact);
    $("#nouveauCommentaire").on("submit", function (e)
    {

        e.preventDefault();
        var route = Routing.generate('_lostbook_nouveau_commentaire_annonce_action');

        $("#btnSubmit").attr('disabled', 'disabled');
        var append = "<div class='row'><div class='col-xs-12'><blockquote><p>" + $("#commentaire").val();

        append = append + "</p><footer><strong>" + $("#pseudo").val() + "</strong>, " + "A l'instant";
        append = append + "</footer></blockquoute></div></div>";

        $("#commentairesItems").prepend(append);
        $("#commentaire").val('');

        $.ajax({
            url: route,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (json) {
                $("#btnSubmit").removeAttr('disabled');
            },
            error: function (json)
            {
                $('#reponse').html(
                        "<span class='nok'> Echec de l'enregistrement" + "</span>");
                $("#reponse").fadeOut(10000);
                $("#btnSubmit").removeAttr('disabled');
            }
        });


    });

    $("#contactForm").on('submit', function(e) {
       e.preventDefault(); 
       $("#reponse").html("<span class='rTCGreenText'>Message Envoyé</span>");
          $.ajax({
            url: Routing.generate('_contact_annonceur'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
              
            },
            error: function ()
            {
            }
        });
    });
    
});

