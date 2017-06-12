import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'parameters/sites/create'; }
    getData(){
		return [];
    }
    domReady(){
        let data = this.data;
        let form = $(this.element).find('form');
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/sites/update','store',[data.sites],function(r){
                    $('#sites-new').modal('hide');
                    if($('#sites-table').length){
                        $('#sites-table').DataTable().ajax.reload();

                    }
                });

            }
        });

    }
};
