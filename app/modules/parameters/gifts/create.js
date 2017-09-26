import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'parameters/gift/create'; }
    getData(){
		return [];
    }
    domReady(){
        let data = this.data;
        let form = $(this.element).find('form');
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/gift/update','store',[data.gift],function(r){
                    $('#gift-new').modal('hide');
                    if($('#gift-table').length){
                        $('#gift-table').DataTable().ajax.reload();

                    }
                });

            }
        });

    }
};
