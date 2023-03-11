
$(()=>{
    $('#logout-item').on('click',(e: JQuery.Event)=>{
        e.preventDefault();
        $('#logout-form').trigger('submit');  
    });
});