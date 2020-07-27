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
function translateTagToText(tag){
	let result;
	switch (tag) {
		case 'surname':
			result = 'Прізвище';
			break;
		case 'model':
			result = 'Модлель';
			break;
		case 'id':
			result = 'ID';
			break;
		case 'phone_num':
			result = 'Номер Телефону';
			break;
		case 'broke':
			result = 'Поломка';
			break;
		case 'master':
			result = 'Майстер';
			break;
		case 'date':
			result = 'Дата';
			break;
		case 'price':
			result = 'Ціна';
			break;
		default:
			result = false;
			break;
	}
	return result;
}




class Main{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
		}
			this.filteradd.submit = (data, e) => {
				this.fillterpannel.append(data)
				this.mainfeed.load(this.fillterpannel.getSQL())
			};
			this.fillterpannel.deleted = () => {
				this.mainfeed.load(this.fillterpannel.getSQL())
			}

			this.components.model.subscribe('show', e => {
				$.ajax({
					url: 'php/requsts/getModelStats.php',
					success: data => {
						this.components.model.initChart(JSON.parse(data));
					}
				})
			})
			this.components.model.subscribe('submit', (value, e) => {
				$.ajax({
					url: 'php/requsts/getModelStats.php',
					type: 'POST',
					data: 'val='+value,
					success: data => {
						this.components.model.initChart(JSON.parse(data));						
					}
				})
			})

			this.components.broke.subscribe('show', e => {
				$.ajax({
					url: 'php/requsts/getBrokeStats.php',
					success: data => {
						this.components.broke.initChart(JSON.parse(data));
					}
				})
			})

			this.components.broke.subscribe('submit', (value, e) => {
				$.ajax({
					url: 'php/requsts/getBrokeStats.php',
					type: 'POST',
					data: 'val='+value,
					success: data => {
						this.components.broke.initChart(JSON.parse(data));						
					}
				})
			})

			this.components.master.subscribe('show', e => {
				$.ajax({
					url: 'php/requsts/getMasterStats.php',
					success: data => {
						this.components.master.initChart(JSON.parse(data));
					}
				})
			})

			this.components.master.subscribe('submit', (value, e) => {
				$.ajax({
					url: 'php/requsts/getMasterStats.php',
					type: 'POST',
					data: 'val='+value,
					success: data => {
						this.components.master.initChart(JSON.parse(data));						
					}
				})
			})

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
			let data = new Filter(this.getData()); 
			this.submit(data, e)
		})
	}

	load(tag){
			// console.log(tag)
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
			// console.log($('#'+id+' input'));
			
			
		}


		let blockID = this.blocks.push(new FilterEditionBlock({
			el_selector: '#'+id,
			type: type,
			slug: slug,
		})) - 1;
		// console.log(this.blocks[blockID]);
		
	}
	clear(){
		let main;
		for(let block of this.blocks){
			if(block.type != 'main' ){
				if(block.el != null){
					try{
						this.filter_wrapper_el.removeChild(block.el);
					}catch(erorr){
						console.error('Ellement already not exist');
					}
				}
			}else{
				main = block;
			}
		}	
		this.blocks = [main];
		document.querySelector(this.searchtype).checked = false;
		this.counter = 1;
	}
	submit(data, e){
		console.log(data)
	}
	getData(){
		let res = [];
		let slugs = [];
		
		for(let block of this.blocks){
			if(block.el !== null && !slugs.includes(block.slug)){
				let data = block.getShortData(); 
				res.push(data);	
				slugs.push(block.slug);
			}
		}
		let returnResult = {};

		for(let feed of res){
			for(let key in feed){
				returnResult[key] = feed[key];
			}
		}
		returnResult.exect = document.querySelector(this.searchtype).checked

		this.clear();
		return returnResult;
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
		
		if(this.type == 'date'){

			$(this.el_selector+' input').datepicker({
				format: 'dd:mm:yyyy',
				days: ['Неділля', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П`ятниця', 'Субота'],
				daysShort: ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
				daysMin:   ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
				months:    ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень','Жовтень', 'Листопад', 'Груденьв']  
			  });
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
		}else if (this.type == 'input'  || this.type == 'date'){
			let result = {};
			
			result[this.slug] = findTag(this.el, 'INPUT').value;
			return result;
		}else if(this.type == 'checkbox'){
			let result = {};
			
			result[this.slug] = findTag(this.el, 'INPUT').checked;
			return result;
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
		this.deletingFuncs = [];
	}
	getHTML(id){
		this.selector = '#filter_'+id;
		this.id = id;

		return `
				<div class="filter" id="filter_${id}">
					<h4 class="filter-title">${translateTagToText(this.tag)} Фільтр №${id}</h4>
					<button class="btn filter-close">
						<img src="img/times.svg" alt="close">
					</button>
				</div>
			`;		
	}
	subscribe(type, func){
		if(type == 'deleting'){
			this.deletingFuncs.push(func)
		}
	}
	setEllement(el){
		this.el = el;
		this.closeBtn = findTag(this.el, 'BUTTON').addEventListener('click', e => {
			console.log('asd');
		})
	}
	rebind(){
		this.el = document.querySelector(this.selector);
		if(this.el !== null){
			this.closeBtn = findTag(this.el, 'BUTTON').addEventListener('click', e => {
				this.el.remove();
				for(let func of this.deletingFuncs){func(this.id)}
			})
		}
	}
	getSQL(exact = this.exect){
		
		let sql = '';
		switch(this.tag){
			case 'surname':
			case 'model':
			case 'phone_num':
			case 'broke':
			case 'master':
				if(this.method){
					if(!exact){
						sql = '`'+this.tag+'` LIKE "%'+this.value+'%" ORDER BY `id` DESC'
					}else{
						sql = '`'+this.tag+'` = "'+this.value+'" ORDER BY `id` DESC'
					}
				}else{
					if(!exact){
						sql = '`'+this.tag+'` LIKE "%'+this.value+'%"'
					}else{
						sql = '`'+this.tag+'` = "'+this.value+'"'
					}
				}
					
			break;
			case 'id':
				if(this.method){
					if(!exact){
						sql = '`id_publick` LIKE "%'+this.value+'%" ORDER BY `id` DESC'
					}else{
						sql = '`id_publick` = "'+this.value+'" ORDER BY `id` DESC'
					}
				}else{
					if(!exact){
						sql = '`id_publick` LIKE "%'+this.value+'%"'
					}else{
						sql = '`id_publick` = "'+this.value+'"'
					}
				}
				break;
			case 'date':
					let fromSplited = this.from.split(':');
					let toSplited = this.to.split(':');

					let from = {
						day : fromSplited[0],
						mouth : fromSplited[1],
						year : fromSplited[2],
					}
					let to = {
						day : toSplited[0],
						mouth : toSplited[1],
						year : toSplited[2],
					}

					let yearDelay = to.year - from.year;
					let mouthDelay = to.mouth - from.mouth + 12*yearDelay;
					let dayDelay = to.day - from.day + 31*mouthDelay;
					
					let mouth = parseInt(from.mouth) % 12 - 1;
					let year  = parseInt(from.year);

					let displayDay = '';
					let displayMouth = '';
					
					for (let g = 0; g <= dayDelay; g++) {
						let day = (parseInt(from.day) + g) % 31;
						if(day == 0) {
							day = 31;
						}
						if(day == 1){
							mouth++;
							if(mouth == 13){
								mouth = 1;
								year++;
							}
						}
						
						mouth.toString().length < 2 ? displayMouth = "0"+mouth.toString() : displayMouth = mouth.toString();
						day.toString().length < 2 ? displayDay = "0"+day.toString() : displayDay = day.toString();
						
						sql +=	' `'+this.tag+'` = "'+displayDay+':'+displayMouth+':'+year.toString()+'" OR';


					}

					
					if(this.method){
						return sql.substr(0, sql.length-2)+'ORDER BY `id` DESC ';
					}else{
						return sql.substr(0, sql.length-2);
					}
			break;
			case 'price':
				if(this.method){
					sql = '`price_our` BETWEEN "'+this.from+'" AND "'+this.to+'" ORDER BY `id` DESC';
				}else{
					sql = '`price_our` BETWEEN "'+this.from+'" AND "'+this.to+'" ';
				}
			break;
		}
		return sql+' ';
	}
}
class FilterPannel{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
		}
		this.el = document.querySelector(this.selector);
		this.filters = [];
		this.counter = 0;
	}
	append(filter){
		this.counter++;
		filter.subscribe('deleting', id => {
			console.log(id);
			
			for(let filterID in this.filters){
				if(this.filters[filterID].id == id){
					this.filters[filterID] = null;
					this.deleted();
				}
			}
		})
		this.filters.push(filter);
		this.el.innerHTML += filter.getHTML(this.counter);
		
		for(let filter of this.filters){
			if(filter !== null){
				filter.rebind();
			}
		}
	}
	deleted(){}
	getSQL(){
		
		let sql = 'SELECT `id_publick`, `surname`, `model`, `phone_num`, `broke`, `master`, `date`, `price_our` FROM `remonts` WHERE   ';
		for (let filter of this.filters){
			if(filter !== null){
				sql += '('+filter.getSQL()+') AND ';
			}
		}
		
		return sql.replace('ORDER BY `id` DESC', '') == sql ? sql.substr(0, sql.length-4): sql.replace('ORDER BY `id` DESC', '').substr(0, sql.replace('ORDER BY `id` DESC', '').length-4)+" ORDER BY `id` DESC";
	}
}
class MainFeed{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
		}
		this.el = document.querySelector(this.selector);
	}
	load(sql){
		
		$.ajax({
			url: 'php/requsts/loadmainfeed.php',
			data: 'sql='+sql,
			type: 'POST',
			success: e =>{
				this.el.innerHTML = e;
			}
		})
	}
}
class Component{
	constructor(config){
		for (var key in config) {
      		if (config.hasOwnProperty(key)) {
        		this[key] = config[key];
      		}
		}
		this.el = document.querySelector(this.selector);
		this.subscribedFuncs = {};
		// this.submitter = findTag(this.el, 'BUTTON');
		this.closeBtn = document.querySelector(this.selector+' .modal-close-btn');
		this.submitter = document.querySelector(this.selector+' .modal-submit');
		
		this.input = findTag(this.el, 'INPUT');
		// this.statsEl = document.querySelector(this.selector+' .stats');	

		this.ctx = document.querySelector(this.selector + ' ' + this.canvas).getContext('2d');
		this.target = document.querySelector(this.target_selector);
		
		this.submitter.addEventListener('click', e => {
			// let data = this.input.value;

			if(this.subscribedFuncs.hasOwnProperty('submit')){
				for(let func of this.subscribedFuncs['submit']){
					func(this.input.value, e)
				}
			}
			this.input.value = '';

		})
		this.target.addEventListener('click', e =>{
			if(this.subscribedFuncs.hasOwnProperty('show')){
				for(let func of this.subscribedFuncs['show']){
					func(e)
				}
			}
			this.show();
		})

		this.closeBtn.addEventListener('click', e =>{
			if(this.subscribedFuncs.hasOwnProperty('hide')){
				for(let func of this.subscribedFuncs['hide']){
					func(e)
				}
			}
			this.hide();
		})
	}
	show(){
		this.el.classList.remove('hidden');
	}
	hide(){
		this.el.classList.add('hidden');
	}
	subscribe(type, func){
		if(this.subscribedFuncs.hasOwnProperty(type)){
			this.subscribedFuncs[type].push(func)
		}else{
			this.subscribedFuncs[type] = [];
			this.subscribe(type, func); 
		}
	}
	initChart(data){
		if(this.chart !== undefined) this.chart.destroy();

		this.chart = new Chart(this.ctx, {
			type: 'bar',
			data: {
				labels: data.labels,
				datasets: [{
					label: 'By all time',
					data: data.data,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		})
	}
}

const report = new Main({
	filteradd: new FilterAddPannel({
		filter_wrapper: '.header-filters-pannel',
		submiter: 		'.addfilter',
		searchtype:		'.allarm_of_search_type_submit'
	}),
	fillterpannel: new FilterPannel({
		selector: '.filter-container'
	}),
	mainfeed: new MainFeed({
		selector: '.main-container'
	}),
	components: {
		model: new Component({
			selector: '.model-modal',
			canvas:   '.modalchart',
			target_selector: '.model-stats-block'
		}),
		broke: new Component({
			selector: '.broke-modal',
			canvas:   '.brokechart',
			target_selector: '.broke-stats-block'
		}),
		master: new Component({
			selector: '.master-modal',
			canvas:   '.masterchart',
			target_selector: '.master-stats-block'
		}),
	}
})

