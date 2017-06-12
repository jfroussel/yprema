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
    domReady(){

        var self = this;
        var data = self.data;
        // var element = self.element;
        $("input[name~='barcode']").focus();
        var barcode = $("#barcode");
        if(barcode.val() != null){
            barcode.blur(function(){
                $("#success").show();
                $("#code").append(barcode.val());
                $serviceJSON('home/tab-home','getChauffeurInfo',[barcode.val()], function(r){
                   $("#nom").append(r.nom);
                   $("#prenom").append(r.prenom);
                   $("#civ").append(r.civ);
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
