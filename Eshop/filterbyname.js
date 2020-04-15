$(document).ready(function(){

    var $btns = $(".filter-button").click(function(){
        if(this.id == 'all')
        {
            //$('.filter').removeClass('hidden');
            $('#myrow > div').fadeIn(450);
            
        }
        else
        {
            var $el = $('.' + this.id).fadeIn(450);
            $('#myrow > div').not($el).hide();
            
        }
        $btns.removeClass('active');
        $(this).addClass('active');
    })
    var $search = $("#myInput").on('input',function()
    {
        $btns.removeClass('active');
        var matcher = new RegExp($(this).val(),'im');
        $('.pro').show().not(function(){ 
            return matcher.test($(this).find('.produkti').text())

        }).hide();
        
    })
})