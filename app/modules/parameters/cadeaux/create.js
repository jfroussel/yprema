import 'validate';
import 'app.datatables';

import Module from 'module';
export default class extends Module {
	templateUrl(){ return 'parameters/cadeaux/create'; }
    getData(){
		return [];
    }
    domReady(){
        let data = this.data;
        let form = $(this.element).find('form');
        form.validate({
            submitHandler: function(e){

                $serviceJSON('parameters/cadeaux/update','store',[data.cadeaux],function(r){
                    $('#cadeaux-new').modal('hide');
                    if($('#cadeaux-table').length){
                        $('#cadeaux-table').DataTable().ajax.reload();

                    }
                });

            }
        });

    }
};
