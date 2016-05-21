$(document).ready(function () {
    /**
     * Lorsque la page se charge, on rempli la variable qui contient les espaces
     * de la ville par défaut.
     */
    //updateEspace();
    RecompenseTrigger();
    CategorieTrigger();
    
    //A chaque fois que la ville change, on recharge les espaces
   // $("#annonce_ville").bind('change',updateEspace);
    
    /**
     * Cette fonction teste si value est contenue dans le tableau array
     * @param {type} value
     * @param {type} array
     * @returns {Boolean}
     */
   function isInArray(value, array)
   {
     return array.indexOf(value) > -1;
   }
    /**
     * Cette fonction est appellée chaque fois que la ville selectionnée change
     * @returns {undefined}
     */
    function updateEspace(){
       
        var tableau = [];
       
        var ajaxRoute = Routing.generate('_espaces_for_ville',{ idVille: $("#annonce_ville").val() });
        $("#annonce_idEspaceHandler").val('loading ...');
        $.ajax({  
           url :  ajaxRoute,
           type : 'POST',
           dataType: 'json',
           success: function(data)
           {
              $("#annonce_idEspaceHandler").val('');
              for(var i in data)
               {         
                
                  tableau.push(data[i].nom );  
               }                             
               $("#annonce_idEspaceHandler" ).autocomplete({
                   source: tableau,
                   change:function(event, ui)
                   {
                       var valeur = $("#annonce_idEspaceHandler" ).val();
                       if(!isInArray(valeur,tableau))
                       {
                           $("#messageEspace").html("<span class='nok' style='padding-top:50px;'>Espace inexistant</span>");
                           //$("#annonce_idEspaceHandler" ).val("");
                       }
                       
                   }
                 });
                 
           },
           error: function(data)
           {
               alert("Echec");
               console.log(data);
           }
            
        });
    }
    
    
    $("#annonce_avecRecompense").bind("change",RecompenseTrigger);
    $("#annonce_categorie").bind("change", CategorieTrigger);
    
   function RecompenseTrigger()
   {
       if($(this).is(':checked'))
       {
           $("#montantRecompenseGroup").show();
           $("#autreRecompenseGroup").show();
       }
       else
       {
           $("#montantRecompenseGroup").hide();
           $("#autreRecompenseGroup").hide();
       }
   }
   
   function CategorieTrigger()
   {
       if($("#annonce_categorie").val() === "4" || $("#annonce_categorie").val() === "5")
       {
           $(".piecesPersos").show();
                }
       else
       {
           $(".piecesPersos").hide();
           
       }
   }
   
   
 

});

