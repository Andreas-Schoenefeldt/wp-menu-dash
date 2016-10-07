(function($, document){
    $(document).ready(function(){

        $(document).on('change', '.adm-wmd-checker', function(){
            var box = $(this).closest('.adm-wmd').find('.adm-wmd__box').stop();

            if (this.checked) {
                box.slideDown(180);
            } else {
                box.slideUp(140);
            }
        });

    });
})(jQuery, document);