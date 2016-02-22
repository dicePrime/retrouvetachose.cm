$(document).ready(function () {

    
   
    
  

    /**
     * Lorsque la page se charge, on rempli la variable qui contient les espaces
     * de la ville par défaut.
     */
    updateEspace();
      
    //A chaque fois que la ville change, on recharge les espaces
    $("#rechercheAnnonces_ville").bind('change',updateEspace);
    
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
        var val = $("#rechercheAnnonces_ville").val();
       
        if(val !== '')
        {
         
         var ajaxRoute = Routing.generate('_espaces_for_ville',{ idVille: $("#rechercheAnnonces_ville").val() });
        $("#rechercheAnnonces_espace").val('loading ...');
        alert(val);
        $.ajax({  
           url :  ajaxRoute,
           type : 'POST',
           dataType: 'json',
           success: function(data)
           {
              $("#rechercheAnnonces_espace").val('');
              for(var i in data)
               {              
                  
                  tableau.push(data[i].id+"   -   "+data[i].nom );  
               }                             
               $("#rechercheAnnonces_espace" ).autocomplete({
                   source: tableau,
                   change:function(event, ui)
                   {
                       var valeur = $("#rechercheAnnonces_espace" ).val();
                       if(!isInArray(valeur,tableau))
                       {
                           $("#rechercheAnnonces_espace" ).val("");
                       }
                       
                   }
                 });
                 
           },
           error: function(data)
           {
              
               console.log(data);
           }
            
        });
    }
    }
    
    
   
   
 

});

