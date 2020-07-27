const addBtn = document.querySelector('.add');
const addInput = document.querySelector('#newmaster');

const delay = ms => new Promise((resolve, reject) => {setTimeout(()=>resolve(), ms)} );
const isJson = json => {
    try {
        JSON.parse(json);
    } catch (error) {
        return false;
    }
        return true;
}



addBtn.addEventListener('click', async e => {
    let name =  addInput.value;
    if(name == ''){
        addBtn.classList.add('danger')
        await delay(1000);
        addBtn.classList.remove('danger')
        return
    }else{
        $.ajax({
            url: 'php/requsts/mastercontorll.php',
            data: 'name='+name,
            type: 'POST',
            success: async e => {
                if(isJson(e)){
                    let data = JSON.parse(e);
                    console.log(data);
                    
                    if(data.type == 'error'){
                        alert(data.message);

                        addBtn.classList.add('danger')
                        await delay(1000);
                        addBtn.classList.remove('danger')

                        return;
                    }
                }else{
                    document.querySelector('.items').innerHTML = e;
                    addInput.value = '';

                    removeBtsArray = document.querySelectorAll('.remove');
                    for(let btn of removeBtsArray){
                        btn.addEventListener('click', e => {
                            let id = e.target.getAttribute('data-id');
                            $.ajax({
                                url: 'php/requsts/mastercontorll.php',
                                data: 'id='+id,
                                type: 'POST',
                                success: e => {
                                    document.querySelector('.items').innerHTML = e;
                                }
                            })
                        })
                    }

                    addBtn.classList.add('success')
                        await delay(1000);
                    addBtn.classList.remove('success')


                }
                
            }
        })
    }  
})

removeBtsArray = document.querySelectorAll('.remove');
for(let btn of removeBtsArray){
    btn.addEventListener('click', e => {
        let id = e.target.getAttribute('data-id');
        $.ajax({
            url: 'php/requsts/mastercontorll.php',
            data: 'id='+id,
            type: 'POST',
            success: e => {
                document.querySelector('.items').innerHTML = e;
            }
        })
    })
}
