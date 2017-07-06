import 'chart.js';
import moment from 'moment';
import 'notify-js';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'home/tab-home'; }
    getData(){
        return [
            $serviceJSON('home/tab-home','load'),
        ];

    }
    setData(json){
        $.extend(this.data,json);
        var data = this.data;
        data.driver = {};
    }
    domReady(){

        var self = this;
        var data = self.data;



        // var element = self.element;
        let inputBarcode = $("input[name~='barcode']");
        inputBarcode.focus();



        let barcode = $("#barcode");

        if(barcode.val() == ''){
            $("#success").hide();
        }

        if(barcode.val() != null){
            barcode.focusout(function(){
                $("#success").show();
                $("#code").append(barcode.val());
                $serviceJSON('home/tab-home','getChauffeurInfo',[barcode.val()], function(r){
                  data.driver = {
                      "nom":r.nom,
                      "prenom":r.prenom,
                      "entreprise":r.entreprise,
                      "adresse":r.adresse,
                      "cp":r.code_postal,
                      "ville":r.ville,
                      "portable":r.portable,
                      "email":r.email,
                      "statut":r.statut,
                      "solde_base":r.solde_base,
                      "solde_bonus":r.solde_bonus,
                      "site_creation":r.site_creation,
                      "date_creation":r.date_creation,
                  };


                   $("#statut").append("Carte crée le " + moment(r.date_creation).format('DD/MM/YYYY') + " son statut est  " + r.statut );

                   if(r.statut == 'actif'){
                       $("#success").addClass('alert alert-success');
                   }else if(r.statut == 'inactif'){
                       $("#success").addClass('alert alert-danger');
                       $(".jumbotron").hide();
                       $("#actualise").show();
                       $("#actualise").on('click', function(){
                           location.reload();
                       });
                   }
                });
            });
        }





        var form = $(this.element).find('form');

        form.validate({
            submitHandler: function(e){
                $serviceJSON('home/tab-home','store',[data.passage],function(r){
                    if($('#passage').length){
                        $.notify('Le passage a bien été enregistré avec la carte n°' + data.passage.barcode, "success");
                    }
                });
                $('#passage').ajax.reload();
            }
        });

    }
};
