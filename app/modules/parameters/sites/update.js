import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	
	templateUrl(){ return 'parameters/sites/update'; }
    
    getData(){

        let id = $(this.element).data('datatable-edit-id');
        //let id = jstack.url.getParams(this.hash).id;
        this.data.id = id;
        return [
            $serviceJSON('parameters/sites/update','load',[id]),
        ];
    }
    
    domReady(){

        var self = this;
        var data = this.data;
        var el = $(self.element);
        var form = $(this.element).find('form');

        console.log(form);
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/sites/update','store',[data.sites],function(r){
                    el.closest('.modal').modal('hide');
                    if($('#sites-table').length){
                        $('#sites-table').DataTable().ajax.reload();

                    }
                });

            }
        });



    }
};
