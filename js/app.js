const body = document.body,
    html = document.documentElement;
const pageWidth = window.innerWidth;

const copyToClipboard = str => {
  const el = document.createElement('textarea');
  el.value = str;
  el.classList.add('coppy');
  document.body.appendChild(el);
  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);
};

const delay = (ms) => {
  return new Promise(
    (resolve, reject) => {
      setTimeout(
        () => {
          resolve();
        }, ms
      )
    }
  );
}
isJson = (json) => {
  try {
    JSON.parse(json);
  } catch (e) {
    return false;
  } return true;
}
class Main {
  constructor(config) {
    // this.config = config;
    for (var key in config) {
      if (config.hasOwnProperty(key)) {
        this[key] = config[key];
      }
    }

    this.init()
  }
  init(){
    this.search.input = (e, value) => {
      if(value != ''){
        $.ajax({
          url: 'php/requsts/find.php',
          type: 'POST',
          data: 'data='+value,
          success: (html) => {
            this.feed.el.innerHTML = html;
            for(let block of document.getElementsByClassName('feed-item-info-wrapper')){
              block.addEventListener('click', (e) => {
                if(pageWidth <= 800){
                  this.editor.el.parentElement.classList.remove('hidden');
                  this.editor.el.parentElement.classList.add('mobile');
                  this.instruments.back.el.classList.remove('hidden');
                  this.feed.wrapper.classList.add('hidden');
                }

                for(let child of block.children){
                  if(child.classList.contains('id_for_loading')){
                    this.history.clean();
                    this.editor.load(child.innerHTML);
                  }
                }
              })
            }
          }
        })
      }
    }
    this.printerEL = false;
    this.instruments.toggle_menu.init = e => {
      this.menu.classList.toggle('opened');
    }
    window.onbeforeprint = () => {
      document.querySelector('main').classList.add('hidden');
      document.querySelector('header').classList.add('hidden');
      document.querySelector('footer').classList.add('hidden');
      
      const el = document.createElement('div');
      let str = "<center><b>Ремонт мобільних пристроїв (МП)\n<br>Магазин «Техномережа F5» (4) тел.+380667819079,+380969115995\<hr> <h1>код:"+this.editor.idContainer.innerHTML+"</h1>\n<hr></b></center><b><br>дата прийому "+this.editor.feeds.date.value+" дата видачі________\n<br>ПІП: "+this.editor.feeds.surname.value+"____________________________________________________________________________________\n<br> Модель, сер-й номер: "+this.editor.feeds.model.value+" __________________________________________________________________\n<br> Заявлена несправність,примітки: "+this.editor.feeds.broke.value+" _________________________________________________________\n<br> Виконані роботи,ціна ремонту,гарантія, примітка: "+this.editor.feeds.imei.value+"\n<br><hr>\nhttp://f5remont.beget.tech/client.php?id="+this.editor.idContainer.innerHTML+"\n@F5Remontsbot - наш телеграм бот!\n<hr><div style='float: left;display: flex;align-items: center;justify-content: center; width: 100%;'><div style='width:70%; font-size: 14px;height:70%;'>-Не залишайте в МП  СІМ-картки і картки пам’яті\n<br>-При значних механічних чи хімічних пошкодженнях МП може не вмикатись чи втратити деякі функції  після ремонту, особисті дані можуть бути втрачені.  \n<br>-Ціну ремонту, необхідність збереження особистих даних клієнт погоджує при здачі телефону чи в процесі ремонту (при необхідності)\n<br>-після ремонту пристрій зберігається до 3 місяців після чого може бути використаний для компенсації витрат на ремонт і зберігання\n<br>- видача пристрою без талону коштує 20грн – здійснюється після перевірки особистих даних \n<br>З правилами ремонту згідний(а)___________________\n<br>\n<br></div><center><div style='width:50%;' id='output'></div></center><b>";
      el.innerHTML = str;
      this.printerEL = el;
      document.body.appendChild(el);

      let qrcode = new QRCode("output", {
            text: "http://f5remont.beget.tech/client.php?id="+this.editor.idContainer.innerHTML,
            width: 177,
            height: 177,
            colorDark : "#222",
            colorLight : "#f3f3f3",
            correctLevel : QRCode.CorrectLevel.H
        });
    }
    window.onafterprint = () => {
      document.querySelector('main').classList.remove('hidden');
      document.querySelector('header').classList.remove('hidden');
      document.querySelector('footer').classList.remove('hidden');

      document.body.removeChild(this.printerEL);
    }
    this.instruments.coppy.init = (e) => {
      if(this.editor.loadedId !== false){
        let data = this.editor.getShortData();
        copyToClipboard(data); 
        this.instruments.coppy.el.classList.add('success');
        delay('1000').then(() => {
          this.instruments.coppy.el.classList.remove('success');
        })
      }
    }
    this.instruments.master_coppy.init = (e) => {
      if(this.editor.loadedId !== false){
        let data = this.editor.getMasterShortData();
        copyToClipboard(data); 
        this.instruments.master_coppy.el.classList.add('success');
        delay('1000').then(() => {
          this.instruments.master_coppy.el.classList.remove('success');
        })
      }
    }
    this.instruments.call.init = (e) => {
      this.instruments.call.el.setAttribute('href', 'tel: +38'+this.editor.feeds.phone_num.value);
    }
    this.instruments.viber.init = (e) => {
      if(this.editor.loadedId !== false){
        let data = this.editor.getShortViberData();
        copyToClipboard(data); 
        this.instruments.viber.el.classList.add('success');
        delay('1000').then(() => {
          this.instruments.viber.el.classList.remove('success');
        })
        this.instruments.viber.el.setAttribute('href', 'viber://chat?number=+38'+this.editor.feeds.phone_num.value);
      }
    }
    this.instruments.print.init = (e) => {
      window.print();
    }
    this.instruments.addnew.init = (e) => {
      this.components.addnewform.show();
    }
    this.instruments.hideaddnew.init = (e) => {
      this.components.addnewform.hide();
    }
    this.instruments.addstory.init = (e) => {
      if(this.editor.loadedId !== false){
        this.components.addnewhistory.show();
      }
    }
    this.instruments.hideaddnewstory.init = (e) => {
      this.components.addnewhistory.hide();
    }
    this.components.addnewhistory.init = (e) => {
      if(this.editor.loadedId !== false){
        let data = $('.'+e.target.classList[0]).serialize()+'&id='+this.editor.loadedId;
        $.ajax({
          url:  'php/requsts/appendStory.php',
          type: 'POST',
          data: data,
          success: (e) => {
            let response = JSON.parse(e);
            this.components.addnewhistory.hide();
            this.history.init(response);
          }
        })
      }
    }
    this.instruments.showhistrory.init = (e) => {
      if(this.editor.loadedId !== false){
        this.history.show();
      }
    }
    this.instruments.close_history.init = (e) => {
      if(this.editor.loadedId !== false){
        this.history.hide();
      }
    }
    this.instruments.last.init = () => {
      $.ajax({
        url: 'php/requsts/last.php',
        success: e => {
          let data = JSON.parse(e);

          this.search.el.value = data.id_publick;
          this.search.input(null, data.id_publick);

          this.editor.load(data.id)

          if(pageWidth <= 800){
            this.editor.el.parentElement.classList.remove('hidden');
            this.editor.el.parentElement.classList.add('mobile');
            this.instruments.back.el.classList.remove('hidden');
            this.feed.wrapper.classList.add('hidden');


          }
        }
      })
    }

    this.components.addnewform.init = (e) => {
      let data = $(this.components.addnewform.selector).serialize();
      $.ajax({
        url: 'php/requsts/save.php',
        type: 'POST',
        data: data,
        success: (html) => {
          let responce = JSON.parse(html);
          if(responce.type == 'success'){
            $(this.components.addnewform.selector+' input').val('');
            this.components.addnewform.hide();
            this.history.clean();

            this.editor.load(responce.id);

            if(pageWidth <= 800){
              this.editor.el.parentElement.classList.remove('hidden');
              this.editor.el.parentElement.classList.add('mobile');
              this.instruments.back.el.classList.remove('hidden');
              this.feed.wrapper.classList.add('hidden');


            }
          }
        }
      })
    }
    this.editor.setHistoryBlock(this.history);

    if(pageWidth <= 800){
      this.instruments.addnew.el.classList.add('visible')
      this.instruments.back.el.classList.add('hidden');
      this.editor.el.parentElement.classList.add('hidden');
      document.querySelector('.hide').classList.add('hidden')
      this.history.el[0].classList.add('hidden');
      this.instruments.back.init = () => {
        this.instruments.back.el.classList.add('hidden');
        this.editor.el.parentElement.classList.add('hidden');
        this.feed.wrapper.classList.remove('hidden')
      }
    }

  }
}
class SearchBar {
  constructor(el) {
    this.el = document.querySelector(el);
    this.el.addEventListener('input', (e) => {this.input(e, this.el.value)})
  }
  input(e, value){
  }
}
class Feed {
  constructor(el, wrapper){
    this.el = document.querySelector(el);
    this.wrapper = document.querySelector(wrapper);
  }
  append(block){
    this.el.innerHTML += block.getHTML();
  }

}
class Editor {
  constructor(el, item_wrapper) {
    this.loadedId = false;
    this.historyBlock = false;
    this.el = document.querySelector(el);
    let feedsItems = document.getElementsByClassName(item_wrapper);
    let feedsArray = {};

    for( let feed of feedsItems){
      let input = feed.children[1];
      feedsArray[input.getAttribute('name')] = input;
    }
    this.idContainer = document.querySelector('.formid');
    this.savebyContainer = document.querySelector('.formsaveby');

    this.feeds = feedsArray;
    for(let feed in this.feeds){
      this.feeds[feed].addEventListener('input', (e) => {
        this.save(this.feeds[feed].value, feed)
      })
    }
  }
  getMasterShortData(){
    return `
      ${this.feeds.surname.value}
      ${this.feeds.model.value}
      ${this.feeds.date.value}
      ${this.feeds.broke.value}
    `
  }
  getShortViberData(){
    let price = parseInt(this.feeds.price_our.value);
 
    return `Доброго дня! ваш пристрій (${this.feeds.model.value}) ${!price ?  "не поремонтовано" : `поремонтовано. Ціна: ${price}`}`
  }
  getShortData(){
    let master = '';
    let input = this.feeds.master.value;
    if(input == 'Стасік' || input == 'Стас'){
      master = 'CT';
    }else if(input == 'Радіо Лайн' || input == 'Радіо'){
      master = 'РЛ';
    }else if(input == 'Радіо Лайн' || input == 'Радіо'){
      master = 'РЛ';
    }else if(input == 'Дисконт'){
      master = 'ДМ';
    }else if(input == 'Саша Мирончук' || input == 'Саша'){
      master = 'СМ';
    }else if(input == 'Саша Пасевич' || input == 'Саша П'){
      master = 'СП';
    }else if(input == 'Міша'){
      master = 'М';
    }else{
      master = input;
    }
    return `(Н)${this.feeds.surname.value} : ${this.feeds.date.value.substr(0,5)}
${this.feeds.phone_num.value} ${master}
${this.feeds.broke.value}
${this.idContainer.innerHTML}`
  }
  setHistoryBlock(historyBlock){
    this.historyBlock = historyBlock;
  }
  load(id){
    this.loadedId = id;
    $.ajax({
      url: 'php/requsts/load.php',
      type: 'GET',
      data: 'id='+id,
      success: (e) => {
        this.el.parentElement.classList.remove('hidden');
        let res = JSON.parse(e);
        for(let key in res){
          if(this.feeds.hasOwnProperty(key)){
            this.feeds[key].value = res[key];
          }
        }
        this.idContainer.innerHTML = res.id_publick;
        this.savebyContainer.innerHTML = "/"+res.savedby;

        if(this.historyBlock !== false){
          this.historyBlock.el.innerHTML = '';
        }
        if(this.historyBlock !== false && isJson(res.history)){
          this.historyBlock.init(JSON.parse(res.history));
        }

        if(res.warriaty != '0'){
          this.feeds.wariaty.setAttribute('checked', '');
        }
      }
    })
  }
  save(val, tag){
    if(this.loadedId !== false){
      $.ajax({
        url:  'php/requsts/update.php',
        data: 'val='+val+'&table='+tag+"&id="+this.loadedId,
        type: 'POST'
      })
    }
  }
}

class Button {
  constructor(el) {
    this.el = document.querySelector(el);
    this.el.addEventListener('click', (e)=>{this.init(e)})
  }
  init(e){
  }
}
class HistoryBlock {
  constructor(el, wrapper) {
    this.el = document.querySelectorAll(el);
    this.wrapper = document.querySelector(wrapper);
  }
  clean(){
    for(let el of this.el){
      el.innerHTML = '';
    }
  }
  init(config){
    for(let el of this.el){
      if (config.length != 0) {
      el.innerHTML = '';
      for(let story of config){
        el.innerHTML += `
        <div class="story ">${story.note}:${story.date}</div>
        `
      }
    }
    }
  }
  show(){
    this.wrapper.classList.remove('hidden');
  }
  hide(){
    this.wrapper.classList.add('hidden');
  }
}
class Component {
  constructor(wrapper, el) {
    this.wrapper = document.querySelector(wrapper);
    this.el = document.querySelector(el);
    this.selector = el;

    this.el.addEventListener('submit', (e) => {
      e.preventDefault();
      this.init(e);
    })
  }
  init(e){
    console.log(e);
  }
  show(){
    this.wrapper.classList.remove('hidden');
  }
  hide(){
    this.wrapper.classList.add('hidden');
  }
}
const main = new Main({
  search:            new SearchBar('.searchbar-input'),
  feed:              new Feed('.feed', '.main-feed'),
  editor:            new Editor('.editing-form', 'form-item'),
  history:           new HistoryBlock('.history-body', '.history_wrapper'),
  menu:              document.querySelector('.admin-instruments-menu'),  
  instruments: {
    addnew:          new Button('.addnew'),
    addstory:        new Button('.add-story-item'),
    hideaddnew:      new Button('.addnewformclose'),
    back:            new Button('.back'),
    hideaddnewstory: new Button('.addnewhistoryformclose'),
    showhistrory:    new Button('.show-story'),
    close_history:   new Button('.close-history'),
    coppy:           new Button('.coppy'),
    print:           new Button('.print'),
    call:            new Button('.call'),
    viber:           new Button('.viber'),
    master_coppy:    new Button('.master_coppy'),
    last:            new Button('.last'),
    toggle_menu:     new Button('.menu-togle')
  },
  components: {
    addnewform:      new Component('.addnew_form_wrapper', '.addnew_form'),
    addnewhistory:   new Component('.addnewhistory_form_wrapper', '.addnewhistory_form')
  }
})

$('[data-toggle="datepicker"]').datepicker({
  trigger: document.querySelector('.datepick_btn'),
  format: 'dd:mm:yyyy',
  days: ['Неділля', 'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П`ятниця', 'Субота'],
  daysShort: ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
  daysMin:   ['Нед','Пон','Вів','Сер','Чет','П`ят','Суб'],
  months:    ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень','Жовтень', 'Листопад', 'Груденьв']  
});

$('[data-toggle="datepicker"]').on('change', e => main.search.input(e, e.target.value));