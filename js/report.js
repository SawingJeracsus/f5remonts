function findTag(el, tag){
	// console.log(el)
	if(el.children.length > 0 && el.children != undefined){
			for(let child of el.children){
				if(child.tagName == tag){
					return child;
				}else{
					let c = findTag(child, tag); 
					if (c) return c;
					 
				}
			}

		}
		return null;
}


class Main{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
    	}
	}

}
class FilterAddPannel{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
    	}
    	this.counter = 0;
    	this.blocks = [];

    	this.filter_wrapper_el = document.querySelector(this.filter_wrapper);
    	
    	this.init();
	}
	init(){
		this.addMainBlock();
		this.load('id')
		this.submiter_el = document.querySelector(this.submiter); 
		this.submiter_el.addEventListener('click', e => {
			let data = this.getData(); 
			this.submit(data, e)
		})
	}

	load(tag){
			console.log(tag)
		switch (tag) {
			case 'surname':
			case 'model':
			case 'id':
			case 'phone_num':
			case 'broke':
			case 'master':
					this.clear();
					this.addBlock('Значення:', 'value');
					this.addBlock('Обернений порядок:', 'method', 'checkbox');
			break;
			case 'date':
					this.clear();
					this.addBlock('З:', 'from', 'date');
					this.addBlock('По:', 'to', 'date');
					this.addBlock('Обернений порядок:', 'method', 'checkbox');

			break;
			case 'price':
					this.clear();
					this.addBlock('З:', 'from');
					this.addBlock('По:', 'to');
					this.addBlock('Обернений порядок:', 'method', 'checkbox');

			break;

			default:
				this.clear();
			break;
		}
		for(let block of this.blocks){
				block.init();
		}
	}
	addMainBlock(){
		this.counter++;
		let id = 'main_filter_selector_'+this.counter;
		this.filter_wrapper_el.innerHTML += `
			<div class="filter_block"  id="${id}">
					<h1 class="filter-block-title">
						Сортувати за:
					</h1>
					<div class="filter-block-input-wrapper">
						<select name="sort_type" class="filter-block-input">
							<option value="id">ID</option>
							<option value="surname">Прізвище</option>
						 	<option value="model">Модель</option>	
							<option value="phone_num">Номер телефону</option>	
							<option value="broke">Несправність</option>	
							<option value="master">Майстер</option>	
							<option value="date">Дата</option>	
							<option value="price">Ціна</option>	 
						</select>
					</div>
				</div>
		`;

		let blockID = this.blocks.push(new FilterEditionBlock({
			el_selector: '#'+id,
			type: 'main',
		})) - 1;
		this.blocks[blockID].subscribe('change_sort_type', val => this.load(val))
	}
	addBlock(title, slug, type = 'input'){
		this.counter++;
		let id = type+'_filter_selector_'+this.counter;
		if(type == 'input'){
			this.filter_wrapper_el.innerHTML += `
			<div class="filter_block"  id="${id}">
					<h1 class="filter-block-title">
						${title}
					</h1>
					<div class="filter-block-input-wrapper">
						<input type="text" placeholder="${title}..." class="filter-block-input">
					</div>
				</div>
			`;
		}else if (type == 'checkbox') {
			this.filter_wrapper_el.innerHTML += `
			<div class="filter_block"  id="${id}">
					<h1 class="filter-block-title">
						${title}
					</h1>
					<div class="filter-block-input-wrapper">
						<label class = "filter-block-checkbox-label fc">
						${title}
						<input type="checkbox" class="filter-block-checkbox">
					</label>
					</div>
				</div>
			`;
		}else if(type == 'date'){
			this.filter_wrapper_el.innerHTML += `
			<div class="filter_block"  id="${id}">
					<h1 class="filter-block-title">
						${title}
					</h1>
					<div class="filter-block-input-wrapper">
						<input type="text" placeholder="${title}..." class="filter-block-input" id="${id}-input">
					</div>
				</div>
			`;
			// $('#'+id+'-input').datepicker({
			//   format: 'dd:mm:yyyy',
			//   days: ['Неділля', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П`ятниця', 'Субота'],
			//   daysShort: ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
			//   daysMin:   ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
			//   months:    ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень','Жовтень', 'Листопад', 'Груденьв']  
			// });
		}


		let blockID = this.blocks.push(new FilterEditionBlock({
			el_selector: '#'+id,
			type: type,
			slug: slug
		})) - 1;
	}
	clear(){
		for(let block of this.blocks){
			if(block.type != 'main' && block.el != null)  this.filter_wrapper_el.removeChild(block.el);
		}	
	}
	submit(data, e){
		console.log(data, e)
	}
	getData(){
		let res = [];
		for(let block of this.blocks){
			let data = block.getShortData(); 
			res.push(data);
		}

		return res;
	}
}
class FilterEditionBlock{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
    	}
    	this.change_sort_type_funcs = [];
    	this.init();

	}
	init(){
    	this.el = document.querySelector(this.el_selector);
		if(this.type == 'main'){
			this.select = this.findSelectTag(this.el);
			this.select.addEventListener('change', e => {
				for(let func of this.change_sort_type_funcs){ func(e.target.value) }
				this.select.value = e.target.value;
			})
		}
	}
	findSelectTag(el){
		if(el.children.length > 0 && el.children != undefined){
			
			for(let child of el.children){
				if(child.tagName == "SELECT"){
					return child;
				}else{
					let c = this.findSelectTag(child); 
					if (c) return c;
					 
				}
			}

		}
		return null;
	}
	subscribe(listener, func){
		switch (listener) {
			case 'change_sort_type':
				if(this.type == 'main'){
					this.change_sort_type_funcs.push(func);
				}
				break;
			default:
				// statements_def
				break;
		}
	}
	destroy(){
		this.el.remove()
	}
	getShortData(){
		// console.log(this)
		if(this.type == 'main'){
			return {
				tag: findTag(this.el, 'SELECT').value
			}
		}else if (this.type == 'input' || this.type == 'checkbox' || this.type == 'date'){
			return{
				tag: this.slug,
				value: findTag(this.el, 'INPUT').value
			}
		}
	}
}
class Filter{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
    	}
	}
}

const report = new Main({
	filteradd: new FilterAddPannel({
		filter_wrapper: '.header-filters-pannel',
		submiter: 		'.addfilter',
		searchtype:		'.allarm_of_search_type_submit'
	})
})