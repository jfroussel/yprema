import 'jstack';
export default class extends jstack.Component {
	setData(json){
		if(json){
			$.extend(this.data,json);
		}
	}
};
