let checkboxArray = document.querySelectorAll('input[type="checkbox"]');
for(let checkbox of checkboxArray){
    checkbox.addEventListener('change', e => {
        let id = e.target.getAttribute('data-id');
        let status = e.target.checked;

        $.ajax({
            url: 'php/requsts/updateuser.php',
            data: `id=${id}&status=${status}`,
            type: 'POST',
            success: e => {
                let res = JSON.parse(e);
                console.log(res);
                
                if(res.type == 'error'){
                    alert(res.message);
                }
            }
        })
        
    })
}