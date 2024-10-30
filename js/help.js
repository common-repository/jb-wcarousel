jQuery(document).ready(function(){
    jQuery('#jb-wcarousel').show(); 
    if(jQuery('#jb-wcarousel').size()){
        
        wCarouselWidth = jQuery('#jb-wcarousel').width();
        
        tableHeight = [];
        jQuery('#wCarouselSource > li').each(function(x){
            tableHeight.push(jQuery(this).height())                    
        });

        wCarouselSize = jQuery('#wCarouselSource > li').size();
        tableWidth = wCarouselWidth * wCarouselSize;        

        jQuery('#wCarousel > table').width(tableWidth); 
        jQuery('#wCarousel').height(tableHeight[0]);
        jQuery('#wCarouselSource > li').each(function(){
            html = jQuery(this).html();
            jQuery('#wCarousel tr').append('<td valign="top" width="'+wCarouselWidth+'">'+html+'</td>');
        })
        jQuery('#wCarouselSource').detach();
        
        jQuery('#jb-wcarousel').hover(
            function(){
                if(!jQuery('.wCarouselButton').size()){
                    jQuery('#jb-wcarousel').append('<div id="wCHolder"> <span class="wCarouselButton" id="prev"><</span> <span class="wCarouselButton" id="next">></span></div>');
                    currentPos = 0;
                    currentWidget = 0;
                    jQuery('.wCarouselButton').click(function(){
                        selId = jQuery(this)[0].id;
                        
                        switch(selId){
                            case 'prev':
                                if(currentPos){
                                    currentWidget -= 1;
                                    currentPos -= wCarouselWidth
                                    jQuery('#wCarousel > table').animate({
                                        left: '-'+currentPos 
                                    })   
                                    jQuery('#wCarousel').animate({
                                        height : tableHeight[currentWidget]
                                    })
                                }      
                            break;   
                            case 'next': 
                                
                                if(currentPos + wCarouselWidth < tableWidth){  
                                    currentWidget += 1;    
                                    currentPos += wCarouselWidth 
                                    jQuery('#wCarousel > table').animate({
                                        left: '-'+currentPos 
                                    })
                                    jQuery('#wCarousel').animate({
                                        height : tableHeight[currentWidget]
                                    })
                                }      
                            break;
                        }
                        
                    })
                } 
                else{
                    jQuery('#wCHolder').show()        
                }   
            },
            function(){
                jQuery('#wCHolder').hide()        
            }
        )
    }
    
    
})