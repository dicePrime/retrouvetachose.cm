$(document).ready(function () {
 $("#nouveauCommentaire").on("submit", function (e)
     {
       
        e.preventDefault();
        var route = Routing.generate('nouveau_commentaire_annonce_action');
        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='/img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmit").attr('disabled','disabled');
        
        $.ajax({
           
            url: route,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false, 
            success: function(commentaire){
                       
           var append = "<div class='row'><div class='col-xs-12><blockquote><p>"+commentaire.commentaire;
           
           append = append+"</p><footer><strong>"+commentaire.pseudo+"</strong>, "+commentaire.date;
           append = append+"</footer></blockquoute></div></div>";
   
                $("#commentairesItems").append(append);
                        
                 $('#reponse').html(span + json['message'] +"</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnSubmit").removeAttr('disabled');
           },               
           error:function(json)
           {
               $('#reponse').html(
               "<span class='nok'> Echec de l'enregistrement" + "</span>");
               $("#reponse").fadeOut(10000);
               $("#btnSubmit").removeAttr('disabled');
           }
    });

   
});
});

